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
    Schema::create('tesis', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        
        // Relación con la especialización
        $table->foreignId('especializacion_id')->constrained('especializaciones')->onDelete('cascade');
        
        // Relaciones con las personas
        $table->foreignId('autor_id')->constrained('personas')->onDelete('restrict');
        $table->foreignId('tutor_id')->constrained('personas')->onDelete('restrict');
        
        $table->string('ruta_pdf')->nullable(); // Cambiado a ruta_pdf
        $table->enum('estado', ['recibida', 'en_revision', 'aprobada', 'rechazada'])->default('recibida');
        $table->date('fecha_presentacion')->nullable();
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tesis');
    }
};
