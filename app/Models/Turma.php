<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    protected $fillable = ['nome', 'disciplina_id', 'professor_id'];

    public function disciplina() {
        return $this->belongsTo(Disciplina::class);
    }

    public function professor() {
        return $this->belongsTo(User::class, 'professor_id');
    }

    public function alunos() {
    return $this->belongsToMany(User::class, 'aluno_turma', 'turma_id', 'aluno_id');
}

    public function notas() {
        return $this->hasMany(Nota::class);
    }
}
