@extends('layouts.app')

@section('extra-css')
<style>
    /* Fond de l'espace profond */
    body {
        background-color: #000;
        background-image: radial-gradient(circle at center, #0a0a2a 0%, #000 100%);
        color: #eee;
    }
    
    /* Centrage parfait du formulaire */
    .login-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
    }
    
    /* Le panneau de connexion façon vaisseau spatial */
    .login-card {
        background: rgba(15, 20, 35, 0.85);
        border: 1px solid #4169e1;
        border-radius: 15px;
        box-shadow: 0 0 40px rgba(65, 105, 225, 0.4);
        padding: 40px;
        width: 100%;
        max-width: 450px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    /* Petite ligne décorative en haut de la carte */
    .login-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, transparent, #4169e1, #ffa500, transparent);
    }

    .login-title {
        color: #ffa500;
        text-shadow: 0 0 15px rgba(255, 165, 0, 0.5);
        margin-bottom: 30px;
        font-weight: bold;
    }
    
    .form-group {
        margin-bottom: 25px;
        text-align: left;
    }
    
    .form-group label {
        display: block;
        color: #8892b0;
        margin-bottom: 8px;
        font-size: 0.9em;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    /* Champs de saisie futuristes */
    .form-control {
        width: 100%;
        padding: 15px;
        background: rgba(0, 0, 0, 0.6);
        border: 1px solid #2a3b6c;
        color: white;
        border-radius: 8px;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #4169e1;
        box-shadow: 0 0 15px rgba(65, 105, 225, 0.5);
        background: rgba(10, 15, 30, 0.9);
    }
    
    .btn-login {
        background: linear-gradient(45deg, #4169e1, #2a4baf);
        color: white;
        border: none;
        padding: 15px;
        width: 100%;
        font-size: 1.2em;
        font-weight: bold;
        border-radius: 8px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.2s;
        margin-top: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(65, 105, 225, 0.6);
    }

    /* Messages d'erreur Laravel en rouge lumineux */
    .invalid-feedback {
        color: #ff4d4d;
        font-size: 0.85em;
        margin-top: 8px;
        display: block;
        text-shadow: 0 0 5px rgba(255, 77, 77, 0.5);
    }
</style>
@endsection

@section('content')
<div class="container-fluid login-wrapper">
    <div class="login-card">
        <h2 class="login-title">🚀 Accès à la Station</h2>
        
        <form method="POST" action="{{ route('login') }}">
            @csrf <div class="form-group">
                <label for="email">Identifiant Spatio-Temporel (Email)</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="ex: malick@espace.com">
                
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>Identifiants incorrects ou introuvables.</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Code d'autorisation (Mot de passe)</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                Démarrer la mission
            </button>
        </form>
    </div>
</div>
@endsection
