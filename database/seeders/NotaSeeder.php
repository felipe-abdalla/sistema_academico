<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Nota;

class NotaSeeder extends Seeder
{
    public function run(): void
    {
        Nota::insert([
            [
                'aluno_id' => 3,
                'turma_id' => 1,
                'valor' => 85,
            ],
            [
                'aluno_id' => 4,
                'turma_id' => 1,
                'valor' => 70,
            ],
            [
                'aluno_id' => 3,
                'turma_id' => 2,
                'valor' => 90,
            ],
        ]);
    }
}
