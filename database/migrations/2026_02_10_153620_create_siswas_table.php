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
        Schema::create('siswa', function (Blueprint $table) {
            $table->bigIncrements('id_siswa');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_user');

            $table->string('nisn', 10)->unique();
            $table->string('nama', 32);
            $table->string('kelas', 20);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('no_hp', 12);
            $table->integer('skor')->default(100);
            $table->string('qr_code', 255)->nullable();

            $table->timestamps();

            $table->foreign('id_guru')
                ->references('id_guru')->on('guru')
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
        Schema::dropIfExists('siswas');
    }
};
