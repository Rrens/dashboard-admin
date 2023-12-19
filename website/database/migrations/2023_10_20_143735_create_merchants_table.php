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
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('phone_number');
            $table->longText('address');
            $table->string('city');
            $table->string('province');
            $table->string('profile_picture')->nullable();
            $table->string('npwp');
            $table->string('id_card_number');
            $table->string('is_approve')->nullable();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            // $table->string('token');
            // $table->string('refresh_token');
            $table->dateTime('last_login')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchants');
    }
};
