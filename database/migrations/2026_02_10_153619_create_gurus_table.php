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
        Schema::create('guru', function (Blueprint $table) {
            $table->bigIncrements('id_guru');
            $table->unsignedBigInteger('user_id');

            $table->string('nip', 18)->unique();
            $table->string('nama', 32);
            $table->string('email', 32)->unique();
            $table->string('no_hp', 12);
            $table->enum('jenis_kelamin', ['L', 'P']);

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id_user')->on('users')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
