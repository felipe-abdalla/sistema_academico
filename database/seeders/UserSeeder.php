<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin (Conforme solicitado: admin@admin.com / admin)
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'), // Senha: admin
            'role' => 'admin', // Role CORRETA
        ]);

        // 2. Professor (Necessário para criar turmas)
        User::create([
            'name' => 'Professor João',
            'email' => 'professor@escola.com',
            'password' => Hash::make('123456'),
            'role' => 'professor',
        ]);

        // 3. Alunos (Necessários para testar matrículas e notas)
        User::create([
            'name' => 'Aluno Maria',
            'email' => 'aluno1@escola.com',
            'password' => Hash::make('123456'),
            'role' => 'aluno',
        ]);

        User::create([
            'name' => 'Aluno Carlos',
            'email' => 'aluno2@escola.com',
            'password' => Hash::make('123456'),
            'role' => 'aluno',
        ]);
    }
}