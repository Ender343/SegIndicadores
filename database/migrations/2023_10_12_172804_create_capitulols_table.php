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
        Schema::create('capitulols', function (Blueprint $table) {
            $table->id();
            $table->string('libro');
            $table->integer('pagina_inicio');
            $table->integer('pagina_fin');
            $table->string('isbn')->nullable();
            $table->string('issn')->nullable();
            $table->string('casa_editorial');
            $table->integer('edicion');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capitulols');
    }
};
