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
        Schema::create('chats', function (Blueprint $table) {
            $table->id('id_chat');

            $table->unsignedBigInteger('id_siswa')->nullable();
            $table->unsignedBigInteger('id_user_tujuan')->nullable(); // guru/admin

            $table->string('nama_anonim')->nullable();
            $table->boolean('is_anonymous')->default(true);

            $table->text('last_message')->nullable();
            $table->timestamp('last_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
