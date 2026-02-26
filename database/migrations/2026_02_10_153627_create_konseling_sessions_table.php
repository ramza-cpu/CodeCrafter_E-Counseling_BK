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
Schema::create('konseling_session', function (Blueprint $table) {
    $table->id('id_session');
    $table->string('anonymous_code', 20)->unique();
    $table->string('nickname', 20);
    $table->enum('status', ['aktif','selesai'])->default('aktif');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konseling_sessions');
    }
};
