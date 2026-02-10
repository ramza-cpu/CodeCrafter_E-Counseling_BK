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
       Schema::create('jenis_pelanggaran', function (Blueprint $table) {
    $table->bigIncrements('id_jenis_pelanggaran');
    $table->string('nama_pelanggaran', 50);
    $table->integer('poin');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pelanggarans');
    }
};
