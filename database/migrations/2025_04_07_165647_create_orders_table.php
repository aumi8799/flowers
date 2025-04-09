<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Užsakymo vartotojo ID
            $table->string('delivery_city'); // Pristatymo miestas
            $table->decimal('total_price', 8, 2); // Užsakymo kaina
            $table->string('status')->default('rezervuotas'); // Užsakymo statusas
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
