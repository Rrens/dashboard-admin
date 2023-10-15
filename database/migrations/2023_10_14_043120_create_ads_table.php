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
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            // $table->foreign('location_id')->references('id')->on('users');
            // $table->foreign('category_id')->references('id')->on('users');
            $table->longText('description');
            $table->text('notes');
            $table->decimal('price');
            $table->string('pictures');
            $table->integer('count_order');
            $table->string('rating');
            $table->integer('count_view');
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
