<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ShelterController;
use Illuminate\Support\Facades\Route;

// ==================================================
// ROUTE PRINCIPALE
// ==================================================

// Redirige la page d'accueil vers la liste des animaux
Route::redirect('/', '/animaux');


// ==================================================
// STYLE GUIDE / COMPOSANTS
// ==================================================

// Affiche la page de présentation des composants graphiques
Route::view('/composants', 'styleguide')
    ->name('styleguide');


// ==================================================
// ANIMAUX - LECTURE (READ)
// ==================================================

// Affiche la liste de tous les animaux
Route::get('/animaux', [AnimalController::class, 'index'])
    ->name('animals.index');

// Affiche les détails d'un animal spécifique
Route::get('/animaux/{id}', [AnimalController::class, 'show'])
    ->name('animals.show');


// ==================================================
// ANIMAUX - CRÉATION (CREATE)
// ==================================================

// Affiche le formulaire de création d'un animal
Route::get('/animaux/nouveau', [AnimalController::class, 'create'])
    ->name('animals.create');

// Enregistre un nouvel animal dans la base de données
Route::post('/animaux', [AnimalController::class, 'store'])
    ->name('animals.store');


// ==================================================
// ANIMAUX - MODIFICATION (UPDATE)
// ==================================================

// Affiche le formulaire de modification d'un animal
Route::get('/animaux/{id}/modifier', [AnimalController::class, 'edit'])
    ->name('animals.edit');

// Enregistre les modifications d'un animal
Route::put('/animaux/{id}', [AnimalController::class, 'update'])
    ->name('animals.update');

// Marque un animal comme adopté
Route::patch('/animaux/{id}/adoption', [AnimalController::class, 'adopt'])
    ->name('animals.adopt');


// ==================================================
// ANIMAUX - SUPPRESSION (DELETE)
// ==================================================

// Supprime un animal de la base de données
Route::delete('/animaux/{id}', [AnimalController::class, 'destroy'])
    ->name('animals.destroy');


// ==================================================
// REFUGES
// ==================================================

// Affiche les détails d'un refuge spécifique
Route::get('/refuges/{id}', [ShelterController::class, 'show'])
    ->name('shelters.show');
