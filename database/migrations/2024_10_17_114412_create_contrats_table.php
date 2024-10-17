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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('produit_id')->nullable()->constrained('produits')->onDelete('set null');
            $table->string('Police')->nullable();
            $table->string('N_Quittance')->nullable();
            $table->string('N_Quittance_Annulee')->nullable();
            $table->string('Prime_Pure')->nullable();
            $table->string('Charges_Gestion')->nullable();
            $table->string('Ccial_externe')->nullable();
            $table->string('Frais_acquisition')->nullable();
            $table->string('Frais_de_fractionnement')->nullable();
            $table->string('Droit_entree')->nullable();
            $table->string('Cout_Piece')->nullable();
            $table->string('Prime_Nette')->nullable();
            $table->string('Solde')->nullable();
            $table->string('Montant_a_payer')->nullable();
            $table->string('inenc')->nullable();
            $table->string('Impayes')->nullable();
            $table->string('Encaissements')->nullable();
            $table->string('Production_brute_exo')->nullable();
            $table->string('Date_Comptable')->nullable();
            $table->string('Date_debut_Quittance')->nullable();
            $table->string('Date_Fin_Quittance')->nullable();
            $table->string('Date_Effet_Police')->nullable();
            $table->string('Date_Fin_effet_Police')->nullable();
            $table->string('Date_Resiliation')->nullable();
            $table->string('Periodicite')->nullable();
            $table->string('Fractionnement')->nullable();
            $table->string('N_Assure')->nullable();
            $table->string('N_Payeur')->nullable();
            $table->string('Point_de_vente')->nullable();
            $table->string('convention')->nullable();
            $table->timestamp('Date_Creation')->nullable();
            $table->timestamp('Date_Creation_QCO')->nullable();
            $table->timestamp('Date_Annulation_QCO')->nullable();
            $table->string('Mois_Effet_Quittance')->nullable();
            $table->string('N_Police')->nullable();
            $table->string('N_Client')->nullable();
            $table->timestamp('Date_Naissance');
            $table->string('Adresse')->nullable();
            $table->string('Contact1')->nullable();
            $table->string('Contact2')->nullable();
            $table->string('Nom_et_Prenoms_Assure')->nullable();
            $table->string('NPoint_de_vente')->nullable();
            $table->string('Nom_Point_de_vente')->nullable();
            $table->string('jaagenp_quaag')->nullable();
            $table->string('jaagenp_winag')->nullable();
            $table->string('jaagenp_winit')->nullable();
            $table->string('Typeapporteur')->nullable();
            $table->string('Branche')->nullable();
            $table->string('Reseau')->nullable();
            $table->string('Typeaffaire')->nullable();
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
