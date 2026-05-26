<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tesis', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');

            // Definimos el discriminador justo después del título
            $table->enum('tipo_documento', ['trabajo_grado', 'tesis_posgrado'])
                ->default('trabajo_grado');

            // Relación con especialización (opcional para pregrado)
            // Usamos nullable() directamente aquí
            $table->foreignId('especializacion_id')
                ->nullable()
                ->constrained('especializaciones')
                ->onDelete('set null'); // Si se borra la especialidad, la tesis queda pero sin categoría

            // Relaciones con las personas (Obligatorias)
            $table->foreignId('autor_id')->constrained('personas')->onDelete('restrict');
            $table->foreignId('tutor_id')->constrained('personas')->onDelete('restrict');

            $table->string('ruta_pdf')->nullable();
            $table->enum('estado', ['recibida', 'en_revision', 'aprobada', 'rechazada'])->default('recibida');
            $table->date('fecha_presentacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tesis');
    }
};