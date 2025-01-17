<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('name'); // Nama pengguna
            $table->string('username');
            $table->string('email')->unique(); // Email pengguna (unik)
            $table->string('password'); // Password pengguna (hashed)
            $table->string('role')->default('user'); // Role pengguna (misal: admin/user)
            $table->timestamp('email_verified_at')->nullable(); // Verifikasi email
            $table->rememberToken(); // Token untuk fitur "Remember Me"
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
