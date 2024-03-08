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
        Schema::create('order', function (Blueprint $table) {
            $table->id('order_id');
            $table->date('purchase_date');
            $table->string('address');
            $table->string('phone_number');
            $table->string('status');
            $table->double('total');
            $table->string('payment_status');
            $table->unsignedBigInteger('payment_method_id');
            $table->foreign('payment_method_id')->references('payment_method_id')->on('payment_method');
            $table->unsignedBigInteger('shipping_method_id');
            $table->foreign('shipping_method_id')->references('shipping_method_id')->on('shipping_method');
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
