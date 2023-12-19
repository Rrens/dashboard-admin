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
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('merchant_id')->nullable();
            $table->foreign('merchant_id')->references('id')->on('merchants');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('name');
            $table->longText('description');
            $table->text('notes');
            $table->decimal('price');
            $table->string('picture')->nullable();
            $table->string('city');
            $table->string('province');
            $table->integer('count_order')->nullable();
            $table->string('rating')->nullable();
            $table->integer('count_view')->nullable();
            $table->string('is_approve')->nullable();
            $table->integer('month')->nullable();
            $table->integer('year')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
