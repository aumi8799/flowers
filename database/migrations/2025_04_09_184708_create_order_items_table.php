<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // Susiejimas su užsakymu
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Susiejimas su produktu
            $table->integer('quantity'); // Prekės kiekis
            $table->decimal('price', 8, 2); // Prekės kaina
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
