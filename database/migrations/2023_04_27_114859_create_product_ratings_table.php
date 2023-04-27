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
        Schema::create('product_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->foreignId('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null');
            $table->integer('rating')->min(0)->max(10);
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
        Schema::dropIfExists('product_ratings');
    }
};
