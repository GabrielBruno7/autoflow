<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
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
Route::get('/healthz', function () {return response()->json(['status' => 'OK'], 200);});

Route::post('/register', [AuthController::class, 'actionRegister']);
Route::post('/login', [AuthController::class, 'actionLogin']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use Illuminate\Support\Facades\DB;

Route::get('/db-test', function () {
    try {
        DB::connection()->getPdo();
        return '✅ Conexão com o banco bem-sucedida!';
    } catch (\Exception $e) {
        return '❌ Erro na conexão: ' . $e->getMessage();
    }
});
