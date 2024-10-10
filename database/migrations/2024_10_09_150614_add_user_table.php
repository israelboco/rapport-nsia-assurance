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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('sexe', ['MASCULIN', 'FEMININ'])->default('MASCULIN');
            $table->enum('mode_reglement', ['MOMO', 'BANQUE', 'VIREMENT', 'CHEQUE'])->default('MOMO');
            $table->timestamp('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('fixe')->nullable();
            $table->string('banque')->nullable();
            $table->timestamp('date_collaboration')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIfExists('sexe');
            $table->dropIfExists('date_naissance');
            $table->dropIfExists('lieu_naissance');
            $table->dropIfExists('banque');
            $table->dropIfExists('date_collaboration');
            $table->dropIfExists('mode_reglement');
            $table->dropIfExists('fixe');
            
        });
    }
};
