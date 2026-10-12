<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\ShelterController;
use Illuminate\Support\Facades\Route;

// Page d'accueil
Route::redirect('/', '/animaux');

// Style guide
Route::view('/composants', 'styleguide')
    ->name('styleguide');

// ANIMAUX - LECTURE
Route::get('/animaux', [AnimalController::class, 'index'])
    ->name('animals.index');

// ANIMAUX - CRÉATION
// Cette route doit précéder /animaux/{id}
Route::get('/animaux/nouveau', [AnimalController::class, 'create'])
    ->name('animals.create');

Route::post('/animaux', [AnimalController::class, 'store'])
    ->name('animals.store');

// ANIMAUX - MODIFICATION
Route::get('/animaux/{id}/modifier', [AnimalController::class, 'edit'])
    ->name('animals.edit');

Route::put('/animaux/{id}', [AnimalController::class, 'update'])
    ->name('animals.update');

Route::patch('/animaux/{id}/adoption', [AnimalController::class, 'adopt'])
    ->name('animals.adopt');

// ANIMAUX - SUPPRESSION
Route::delete('/animaux/{id}', [AnimalController::class, 'destroy'])
    ->name('animals.destroy');

// ANIMAUX - DÉTAILS
Route::get('/animaux/{id}', [AnimalController::class, 'show'])
    ->whereNumber('id')
    ->name('animals.show');

// REFUGES
Route::get('/refuges/{id}', [ShelterController::class, 'show'])
    ->whereNumber('id')
    ->name('shelters.show');
