<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function saveScore(Request $request)
    {
        // On vérifie que le score est bien envoyé
        $request->validate([
            'score' => 'required|integer|min:0|max:10',
        ]);

        // On enregistre dans la base de données
        $score = new Score();
        $score->user_id = Auth::id(); // L'ID de l'utilisateur connecté
        $score->score = $request->score;
        $score->total_questions = 10;
        $score->save();

        // On renvoie une réponse au JavaScript avec le nom de l'utilisateur
        return response()->json([
            'success' => true,
            'user_name' => Auth::user()->name,
            'score' => $score->score
        ]);
    }
}
