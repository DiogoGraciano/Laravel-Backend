<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Models\TbEstrategiaWms;
use App\Models\TbEstrategiaWmsHorarioPrioridade;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EstrategiaWMS extends Controller
{
    /**
     * Salva a requisição no banco de dados.
     */
    public function store(Request $request)
    {
        try {

            $request->validate([
                'dsEstrategia' => 'required|max:255',
                'nrPrioridade' => 'required|integer|min:1',
                'horarios.*.dsHorarioInicio' => 'required|date_format:H:i',
                'horarios.*.dsHorarioFinal' => 'required|date_format:H:i',
                'horarios.*.nrPrioridade' => 'required|integer|min:1',
            ]);

            $TbEstrategiaWms = new TbEstrategiaWms();
    
            $TbEstrategiaWms->ds_estrategia_wms = $request->dsEstrategia;
            $TbEstrategiaWms->nr_prioridade = intval($request->nrPrioridade)?:1;
            $TbEstrategiaWms->dt_registro = Carbon::now();
            $TbEstrategiaWms->dt_modificado = Carbon::now();
            $TbEstrategiaWms->save();
    
            foreach ($request->horarios as $horario){
                $TbEstrategiaWmsHorarioPrioridade = new TbEstrategiaWmsHorarioPrioridade();
                $TbEstrategiaWmsHorarioPrioridade->ds_horario_inicio = $horario["dsHorarioInicio"];
                $TbEstrategiaWmsHorarioPrioridade->ds_horario_final  = $horario["dsHorarioFinal"];
                $TbEstrategiaWmsHorarioPrioridade->cd_estrategia_wms = $TbEstrategiaWms->cd_estrategia_wms;
                $TbEstrategiaWmsHorarioPrioridade->nr_prioridade    = $horario["nrPrioridade"];
                $TbEstrategiaWmsHorarioPrioridade->dt_registro     = Carbon::now();
                $TbEstrategiaWmsHorarioPrioridade->dt_modificado   = Carbon::now();
                $TbEstrategiaWmsHorarioPrioridade->save();
            }
    
        } catch (\Exception $e) {
            return response()->json(["error" => "Não foi possivel execultar essa ação"],400);
        }
       
        return response()->json(["return" => true],200);
    }

    public function getPrioridade($cdEstrategia, $dsHora, $dsMinuto){
        try {

            $horaCompleta = sprintf('%02d:%02d', $dsHora, $dsMinuto);

            $estrategia = TbEstrategiaWms::find($cdEstrategia);

            if (!$estrategia) {
                return response()->json(['error' => 'Estratégia não encontrada'], 404);
            }

            $horarios = TbEstrategiaWmsHorarioPrioridade::where('cd_estrategia_wms', $cdEstrategia)->get();
            
            $prioridade = null;
            foreach ($horarios as $horario)
            {
                $inicio = Carbon::createFromFormat('H:i', $horario->ds_horario_inicio);
                $final = Carbon::createFromFormat('H:i', $horario->ds_horario_final);
                $horaAtual = Carbon::createFromFormat('H:i', $horaCompleta);

                if ($inicio <= $horaAtual && $horaAtual <= $final) {
                    $prioridade = $horario->nr_prioridade;
                    break;
                }
            }

            if ($prioridade) {
                return response()->json(['prioridade' => $prioridade]);
            } 
                
            return response()->json(['prioridade' => $estrategia->nr_prioridade]);

        } catch (\Exception $e) {
            return response()->json(["error" => "Não foi possivel execultar essa ação"],400);
        }
    }
}