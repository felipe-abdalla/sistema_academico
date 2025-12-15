<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Disciplina;

class DisciplinaSeeder extends Seeder
{
    public function run(): void
    {
        Disciplina::insert([
            ['nome' => 'Matemática'],
            ['nome' => 'Português'],
            ['nome' => 'História'],
        ]);
    }
}
