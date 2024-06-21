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
            $table->string('cover')->nullable();
            $table->string('bande_annonce')->nullable();
            $table->date('date_sortie')->nullable();
            $table->integer('limite_age')->nullable();
            $table->float('moyenne_note')->nullable();
            $table->string('audio')->nullable();
            $table->foreignId('categorie_id')->constrained('categories');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
