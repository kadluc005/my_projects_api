<?php

use App\Http\Controllers\ProjectController, App\Http\Controllers\EtudiantController;
use App\Models\Etudiant;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
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

Route::post('register', [EtudiantController::class, 'register']);
Route::post('login', [EtudiantController::class, 'login']);

Route::group(['middleware'=>['auth:sanctum']], function(){
    //gestion des etudiants
    Route::get('profile', [EtudiantController::class, 'profile']);
    Route::get('logout', [EtudiantController::class, 'logout']);

    //gestion des projets
    Route::post('creer_projet', [ProjectController::class, 'create']);
    Route::get('list_projets', [ProjectController::class, 'list']);
    Route::get('details_projet/{id}', [ProjectController::class, 'details']);
    Route::delete('delete_projet/{id}', [ProjectController::class, 'delete']);
    Route::patch('update_project/{id}', [ProjectController::class, 'update_project']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
