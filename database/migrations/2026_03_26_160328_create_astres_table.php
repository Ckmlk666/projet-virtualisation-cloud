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
    	Schema::create('astres', function (Blueprint $table) {
        	$table->id();
        	$table->string('nom'); // Ex: Terre, Voie Lactée
        	$table->string('type'); // Ex: Planète, Galaxie, Etoile
        	$table->text('description'); // Le texte du documentaire
        	$table->string('distance')->nullable(); // Distance du soleil
        	$table->timestamps();
    	});
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('astres');
    }
};
