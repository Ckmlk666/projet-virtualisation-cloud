<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Question;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        Question::create([
            'question' => 'Quelle est la plus grande planète du système solaire ?',
            'choix_a' => 'La Terre',
            'choix_b' => 'Jupiter',
            'choix_c' => 'Saturne',
            'choix_d' => 'Mars',
            'reponse_correcte' => 'b'
        ]);

        Question::create([
            'question' => 'Quelle planète est surnommée la planète rouge ?',
            'choix_a' => 'Vénus',
            'choix_b' => 'Mercure',
            'choix_c' => 'Mars',
            'choix_d' => 'Uranus',
            'reponse_correcte' => 'c'
        ]);

        Question::create([
            'question' => 'Combien de temps met la lumière du Soleil pour atteindre la Terre ?',
            'choix_a' => 'Environ 8 minutes',
            'choix_b' => 'Environ 1 heure',
            'choix_c' => 'Quelques secondes',
            'choix_d' => '24 heures',
            'reponse_correcte' => 'a'
        ]);
        
        // Ajoute les 17 autres questions ici sur le même modèle !
    }
}
