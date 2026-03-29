<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    // Affiche la page de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Traite la tentative de connexion
    public function login(Request $request)
    {
        // 1. Vérification des champs
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Tentative de connexion à la base de données
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Si ça marche, on l'envoie direct vers le quiz !
            return redirect()->intended('/'); 
        }

        // 3. Si ça rate (mauvais mot de passe), on le renvoie avec une erreur
        return back()->withErrors([
            'email' => 'Identifiants spatio-temporels incorrects.',
        ])->onlyInput('email');
    }

    // Pour se déconnecter
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
