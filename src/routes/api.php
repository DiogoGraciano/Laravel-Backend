<?php

use App\Http\Controllers\EstrategiaWMS;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/estrategiaWMS',[EstrategiaWMS::class, 'store']);
Route::get('/estrategiaWMS/{cdEstrategia}/{dsHora}/{dsMinuto}/prioridade',[EstrategiaWMS::class, 'getPrioridade']);
 