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
        Schema::create('equipoinformaticos', function (Blueprint $table) {
            $table->id();
            $table->string('marca'); 
            $table->string('modelo'); 
            $table->string('estado'); 
            $table->foreignId('laboratorio_id')->nullable()->constrained('laboratorios')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipoinformaticos');
    }
};
