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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->unique(); // Exemple: Responsable Réseau
            $table->unsignedInteger('niveau'); // Niveau de permission
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->boolean('remove')->default(false); // Association au service
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
