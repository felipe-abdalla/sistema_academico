<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $fillable = ['nome', 'descricao'];

    public function turmas() {
        return $this->hasMany(Turma::class);
    }
}
