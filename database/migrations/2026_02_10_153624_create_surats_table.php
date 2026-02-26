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
            $table->id('id_surat');

            $table->foreignId('id_siswa')
                ->constrained('siswa', 'id_siswa')
                ->cascadeOnDelete();

            $table->foreignId('id_guru')
                ->constrained('guru', 'id_guru')
                ->cascadeOnDelete();

            $table->string('nomor_surat', 50);
            $table->string('jenis_surat', 50);
            $table->dateTime('tanggal_cetak');
            $table->text('isi_surat');

            $table->enum('status', ['pending', 'tercetak'])
                ->default('pending');

            $table->timestamps();
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
