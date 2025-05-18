<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrdinationController;

Route::prefix('ordination')->group(function () {
    Route::get('/patienter', [OrdinationController::class, 'getPatienter']);
    Route::get('/laegemidler', [OrdinationController::class, 'getLaegemidler']);
    Route::get('/anbefalet-dosis/{patientId}/{laegemiddelId}', [OrdinationController::class, 'getAnbefaletDosisPerDoegn']);
    Route::get('/daglig-faste', [OrdinationController::class, 'getDagligFaste']);
    Route::get('/daglig-skaeve', [OrdinationController::class, 'getDagligSkaeve']);
    Route::get('/pn', [OrdinationController::class, 'getPN']);
    Route::get('/stats/{vfra}/{vtil}/{laegemiddelId}', [OrdinationController::class, 'getStats']);
    Route::post('/pn', [OrdinationController::class, 'opretPN']);
    Route::post('/daglig-fast', [OrdinationController::class, 'opretDagligFast']);
    Route::post('/daglig-skaev', [OrdinationController::class, 'opretDagligSkaev']);
    Route::post('/anvend', [OrdinationController::class, 'anvendOrdination']);
});
