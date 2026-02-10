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
        Schema::create('konseling_log', function (Blueprint $table) {
            $table->bigIncrements('id_log');
            $table->unsignedBigInteger('id_session');
            $table->unsignedBigInteger('id_siswa');

            $table->timestamps();

            $table->foreign('id_session')
                ->references('id_session')->on('konseling_session')
                ->onDelete('cascade');

            $table->foreign('id_siswa')
                ->references('id_siswa')->on('siswa')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konseling_logs');
    }
};
