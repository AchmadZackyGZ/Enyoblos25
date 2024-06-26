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
        Schema::create('candidatepairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chairman')->unique()->references('id')->on('candidates')->cascadeOnDelete();
            $table->foreignId('vicechairman')->unique()->nullable()->references('id')->on('candidates')->cascadeOnDelete();
            $table->longText('vision');
            $table->longText('mission');
            $table->string('photo');
            $table->integer('score')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatepairs');
    }
};
