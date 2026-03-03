<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersAndGuruTables extends Migration
{
    public function up()
    {
        // Tambah email ke users
        Schema::table('users', function (Blueprint $table) {
            $table->string('email')->unique()->after('username');
        });

        // Hapus email dari guru
        Schema::table('guru', function (Blueprint $table) {
            $table->dropColumn('email');
        });
    }

    public function down()
    {
        // rollback

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('email');
        });

        Schema::table('guru', function (Blueprint $table) {
            $table->string('email')->nullable();
        });
    }
}