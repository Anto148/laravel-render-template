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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('titre')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('duree')->nullable();
            $table->string('cover_url')->nullable();
            $table->string('bande_annonce')->nullable();
            $table->string('date_sortie')->nullable();
            $table->integer('limite_age')->nullable();
            $table->float('moyenne_note')->nullable();
            $table->string('audio')->nullable();
            // $table->foreignId('realisateur_id')->constrained('realisateurs');
            // $table->foreignId('acteurs_id')->constrained('acteurs');
            // $table->foreignId('categorie_id')->constrained('categories');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('film_realisateur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained()->onDelete('cascade');
            $table->foreignId('realisateur_id')->constrained()->onDelete('cascade');
        });

        Schema::create('film_acteur', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained()->onDelete('cascade');
            $table->foreignId('acteur_id')->constrained()->onDelete('cascade');
        });

        Schema::create('categorie_film', function (Blueprint $table) {
            $table->id();
            $table->foreignId('film_id')->constrained()->onDelete('cascade');
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorie_film');
        Schema::dropIfExists('film_acteur');
        Schema::dropIfExists('film_realisateur');
        Schema::dropIfExists('films');
    }
};
