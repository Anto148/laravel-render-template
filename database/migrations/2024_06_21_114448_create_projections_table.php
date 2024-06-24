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
        Schema::create('projections', function (Blueprint $table) {
            $table->id();
            $table->date('date_projection')->nullable();
            $table->time('heure_projection')->nullable();
            $table->boolean('en_3d')->nullable();
            $table->foreignId('film_id')->nullable()->references('id')->on('films')->onDelete('cascade');
            $table->foreignId('salle_id')->nullable()->references('id')->on('salles')->onDelete('cascade');
            $table->foreignId('created_by_id')->nullable()->references('id')->on('users')->constrained();
            $table->foreignId('type_projection_id')->nullable()->references('id')->on('type_projections')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projections');
    }
};
