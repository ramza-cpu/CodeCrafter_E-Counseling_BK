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
            $table->id('id_pelanggaran');

            $table->foreignId('id_siswa')
                ->constrained('siswa', 'id_siswa')
                ->cascadeOnDelete();

            $table->foreignId('id_jenis_pelanggaran')
                ->constrained('jenis_pelanggaran', 'id_jenis_pelanggaran')
                ->cascadeOnDelete();

            $table->foreignId('id_guru')
                ->constrained('guru', 'id_guru')
                ->cascadeOnDelete();

            $table->timestamp('tanggal')->useCurrent();
            $table->integer('poin');
            $table->text('keterangan')->nullable();

            $table->timestamps();
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
