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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category');
            $table->foreign('category')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->string('tittle');
            $table->string('slug');
            $table->longText('description');
            $table->decimal('price');
            $table->boolean('isAvailable');
            $table->boolean('isFavorite');
            $table->bigInteger('count')->nullable()->default('0');
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
        Schema::dropIfExists('products');
    }
};
