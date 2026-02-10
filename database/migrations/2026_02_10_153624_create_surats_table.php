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
        Schema::create('surat', function (Blueprint $table) {
            $table->bigIncrements('id_surat');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_guru');

            $table->string('nomor_surat', 50);
            $table->string('jenis_surat', 50);
            $table->dateTime('tanggal_cetak');
            $table->text('isi_surat');

            $table->timestamps();

            $table->foreign('id_siswa')
                ->references('id_siswa')->on('siswa')
                ->onDelete('cascade');

            $table->foreign('id_guru')
                ->references('id_guru')->on('guru')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
