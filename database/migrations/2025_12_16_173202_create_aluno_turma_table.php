<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('aluno_turma', function (Blueprint $table) {
        $table->id();
        
        // Cria o vínculo com a tabela de turmas
        $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');
        
        // Cria o vínculo com a tabela de usuários (alunos)
        $table->foreignId('aluno_id')->constrained('users')->onDelete('cascade');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aluno_turma');
    }
};
