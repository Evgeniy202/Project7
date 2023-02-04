<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->foreignId('order')
                ->references('id')
                ->on('orders')
                ->onDelete('cascade');
            $table->foreignId('product')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->bigInteger('number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
};
