<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Astre;
use App\Models\Question;

class SystemeSolaireController extends Controller
{
    public function terre() {
        // On récupère juste la Terre depuis la base de données
        $terre = Astre::where('nom', 'La Terre')->first();
        return view('terre', compact('terre'));
    }

    public function systemeSolaire() {
        $astres = Astre::all();
        return view('systeme-solaire', compact('astres'));
    }

    public function galaxie() {
        return view('galaxie');
    }

    public function quiz() {
        // 10 questions aléatoires comme demandé
        $questions = Question::inRandomOrder()->take(10)->get();
        return view('quiz', compact('questions'));
    }
}
