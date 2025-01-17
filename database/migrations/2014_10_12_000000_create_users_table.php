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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable(false);
            $table->string('username', 100)->nullable(false)->unique();
            $table->string('password', 100)->nullable(false);
            $table->string('provinsi', 100)->nullable(false);
            $table->string('kota', 100)->nullable(false);
            $table->string('alamat', 100)->nullable(false);
            $table->string('phone', 100)->nullable(false);
            $table->string('email', 100)->nullable(false);
            $table->date('date_of_birth')->nullable(false);
            $table->string('token', 100)->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
