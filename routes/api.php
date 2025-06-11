<?php

use App\Http\Controllers\XmlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReleveController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/testJson', [XmlController::class, 'testJson'])->name('testJson');

// Routes API pour les relevés
Route::prefix('releves')->group(function () {
    // Routes pour l'eau
    Route::get('/eau/{codeCli}/{refAppTR}/{dateReleve}', [ReleveController::class, 'getCompteursEau']);
    Route::get('/eau/historique/{compteurId}', [ReleveController::class, 'getHistoriqueEau']);
    Route::post('/eau/save', [ReleveController::class, 'saveReleveEau']);

    // Routes pour le gaz
    Route::get('/gaz/{codeCli}/{refAppTR}/{dateReleve}', [ReleveController::class, 'getCompteursGaz']);
    Route::get('/gaz/historique/{compteurId}', [ReleveController::class, 'getHistoriqueGaz']);
    Route::post('/gaz/save', [ReleveController::class, 'saveReleveGaz']);

    // Routes pour l'électricité
    Route::get('/elec/{codeCli}/{refAppTR}/{dateReleve}', [ReleveController::class, 'getCompteursElec']);
    Route::get('/elec/historique/{compteurId}', [ReleveController::class, 'getHistoriqueElec']);
    Route::post('/elec/save', [ReleveController::class, 'saveReleveElec']);

    // Routes pour le chauffage
    Route::get('/chauffage/{codeCli}/{refAppTR}/{dateReleve}', [ReleveController::class, 'getCompteursChauffage']);
    Route::get('/chauffage/historique/{compteurId}', [ReleveController::class, 'getHistoriqueChauffage']);
    Route::post('/chauffage/save', [ReleveController::class, 'saveReleveChauffage']);
});
