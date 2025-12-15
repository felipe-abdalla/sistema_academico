<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Turma;

class TurmaSeeder extends Seeder
{
    public function run(): void
    {
        Turma::insert([
            [
                'nome' => 'Turma A',
                'disciplina_id' => 1,
            ],
            [
                'nome' => 'Turma B',
                'disciplina_id' => 2,
            ],
        ]);
    }
}
