<?php

use App\Http\Controllers\EmpruntController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes CRUD pour l’entité "Emprunt"
Route::prefix('emprunts')->group(function () {
    // Lire tous les emprunts
    Route::get('/', [EmpruntController::class, 'index'])->name('emprunts.index');

    // Créer un nouvel emprunt
    Route::post('/', [EmpruntController::class, 'store'])->name('emprunts.store');

    // Afficher un emprunt précis
    Route::get('/{id}', [EmpruntController::class, 'show'])->name('emprunts.show');

    // Mettre à jour un emprunt existant
    Route::put('/{id}', [EmpruntController::class, 'update'])->name('emprunts.update');

    // Supprimer un emprunt
    Route::delete('/{id}', [EmpruntController::class, 'destroy'])->name('emprunts.destroy');
});
