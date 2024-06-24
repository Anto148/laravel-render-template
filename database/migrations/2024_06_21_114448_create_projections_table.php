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
            $table->foreignId('film_id')->constrained('films')->onDelete('cascade')->nullable();
            $table->foreignId('salle_id')->constrained('salles')->onDelete('cascade')->nullanble();
            $table->foreignId('created_by_id')->nullable()->references('id')->on('users')->constrained();
            $table->foreignId('type_projection_id')->constrained('type_projections')->onDelete('cascade')->nullable();
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
