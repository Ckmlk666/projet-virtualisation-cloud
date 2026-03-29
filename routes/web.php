<?php

use App\Http\Controllers\QuizController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SystemeSolaireController;

// --- ROUTES DE CONNEXION ---
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protège tes routes avec le middleware 'auth'
Route::middleware(['auth'])->group(function () {
    // Si ta route quiz s'appelait juste '/quiz', remplace-la par celle-ci dans le groupe
    Route::get('/quiz', function () {
        return view('quiz');
    })->name('quiz');

    // La route pour sauvegarder en Base de Données
    Route::post('/quiz/save', [QuizController::class, 'saveScore'])->name('quiz.save');
});

Route::get('/', [SystemeSolaireController::class, 'terre']);
Route::get('/systeme-solaire', [SystemeSolaireController::class, 'systemeSolaire']);
Route::get('/galaxie', [SystemeSolaireController::class, 'galaxie']);
Route::get('/quiz', [SystemeSolaireController::class, 'quiz']);
