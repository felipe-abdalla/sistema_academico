<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        // Professor
        User::create([
            'name' => 'Professor João',
            'email' => 'professor@sistema.com',
            'password' => Hash::make('123456'),
            'role' => 'professor',
        ]);

        // Aluno 1
        User::create([
            'name' => 'Aluno Maria',
            'email' => 'aluno1@sistema.com',
            'password' => Hash::make('123456'),
            'role' => 'aluno',
        ]);

        // Aluno 2
        User::create([
            'name' => 'Aluno Carlos',
            'email' => 'aluno2@sistema.com',
            'password' => Hash::make('123456'),
            'role' => 'aluno',
        ]);
    }
}
