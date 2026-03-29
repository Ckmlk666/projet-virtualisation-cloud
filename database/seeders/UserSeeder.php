<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Malick',
            'email' => 'malick@espace.com',
            'password' => Hash::make('password'), // Mot de passe
        ]);

        User::create([
            'name' => 'Mamadou',
            'email' => 'mamadou@espace.com',
            'password' => Hash::make('password'), // Mot de passe
        ]);
    }
}
