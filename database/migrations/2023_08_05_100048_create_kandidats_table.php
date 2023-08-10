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
        Schema::create('kandidats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->references('id')->on('users')->cascadeOnDelete();
            $table->string('nomor_wa', 20);
            $table->text('visi');
            $table->text('misi');
            $table->string('foto');
            $table->string('pdf_ktm');
            $table->string('suket_organisasi');
            $table->string('suket_lkmm_td');
            $table->string('transkrip_nilai');
            $table->integer('skor_fpt')->default(0);
            $table->string('status', 25);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kandidats');
    }
};
