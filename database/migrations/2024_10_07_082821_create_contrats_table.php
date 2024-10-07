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
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Agent créateur
            $table->string('nature');
            $table->decimal('montant', 15, 2);
            $table->string('prospect_nom');
            $table->string('prospect_prenom')->nullable();
            $table->string('prospect_telephone');
            $table->string('prospect_email')->nullable();
            $table->string('lieu_signature');
            $table->enum('statut', ['en attente', 'annuler', 'à conclure']);
            $table->timestamp('date_conclusion')->nullable(); // Date pour calculer le chiffre d'affaires
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrats');

    }
};
