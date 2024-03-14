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
        Schema::create('product_detail', function (Blueprint $table) {
            $table->id('product_detail_id');
            $table->string('image');
            $table->unsignedBigInteger('color_id');
            $table->foreign('color_id')->references('color_id')->on('color');
            $table->unsignedBigInteger('size_id');
            $table->foreign('size_id')->references('size_id')->on('sizes');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('product_id')->on('product');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
