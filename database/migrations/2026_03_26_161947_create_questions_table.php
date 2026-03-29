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
      Schema::create('questions', function (Blueprint $table) {
        $table->id();
        $table->string('question');
        $table->string('choix_a');
        $table->string('choix_b');
        $table->string('choix_c');
        $table->string('choix_d');
        $table->string('reponse_correcte'); // On stockera 'a', 'b', 'c' ou 'd'
        $table->timestamps();
      });
     }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
