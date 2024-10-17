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
        Schema::table('services', function (Blueprint $table) {
            $table->boolean('remove')->default(false);
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->boolean('remove')->default(false);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('remove')->default(false);
        });
        Schema::table('contrats', function (Blueprint $table) {
            $table->boolean('remove')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropIfExists('remove');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropIfExists('remove');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropIfExists('remove');
        });
        Schema::table('contrats', function (Blueprint $table) {
            $table->dropIfExists('remove');
        });
    }
};
