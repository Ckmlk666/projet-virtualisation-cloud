<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Astre;

class AstreSeeder extends Seeder
{
    public function run(): void
    {
        Astre::create([
            'nom' => 'La Voie Lactée',
            'type' => 'Galaxie',
            'description' => 'Notre galaxie spirale contenant des milliards d\'étoiles...',
            'distance' => 'N/A'
        ]);

        Astre::create([
            'nom' => 'Le Soleil',
            'type' => 'Etoile',
            'description' => 'Le cœur incandescent de notre système solaire.',
            'distance' => '0 km'
        ]);

        Astre::create([
            'nom' => 'La Terre',
            'type' => 'Planète',
            'description' => 'Le point bleu pâle, la seule planète connue abritant la vie.',
            'distance' => '149.6 millions de km'
        ]);
    }
}
