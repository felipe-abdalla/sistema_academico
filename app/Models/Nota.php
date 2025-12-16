<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $fillable = ['turma_id', 'aluno_id', 'valor', 'historico'];

    public function turma() {
        return $this->belongsTo(Turma::class);
    }

    public function aluno() {
        return $this->belongsTo(User::class, 'aluno_id');
    }
}
