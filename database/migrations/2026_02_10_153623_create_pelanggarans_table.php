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
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->bigIncrements('id_pelanggaran');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_jenis_pelanggaran');
            $table->unsignedBigInteger('id_guru');

            $table->timestamp('tanggal');
            $table->integer('poin');
            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->foreign('id_siswa')
                ->references('id_siswa')->on('siswa')
                ->onDelete('cascade');

            $table->foreign('id_jenis_pelanggaran')
                ->references('id_jenis_pelanggaran')->on('jenis_pelanggaran')
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
        Schema::dropIfExists('pelanggarans');
    }
};
