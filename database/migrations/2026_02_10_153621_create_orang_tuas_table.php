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
        Schema::create('orang_tua', function (Blueprint $table) {
            $table->bigIncrements('id_ortu');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_user');

            $table->string('nama_ayah', 32);
            $table->string('nama_ibu', 32);
            $table->string('no_hp', 12);
            $table->text('alamat');

            $table->timestamps();

            $table->foreign('id_siswa')
                ->references('id_siswa')->on('siswa')
                ->onDelete('cascade');

            $table->foreign('id_user')
                ->references('id_user')->on('users')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tuas');
    }
};
