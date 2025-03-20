<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();  // Produktų ID
            $table->string('name');  // Prekės pavadinimas
            $table->string('description')->nullable();  // Prekės aprašymas
            $table->decimal('price', 8, 2);  // Prekės kaina
            $table->string('category');  // Kategorija (puokštės, skintos gėlės, miegantys rožės ir pan.)
            $table->string('image');  // Nuotraukos pavadinimas
            $table->timestamps();  // Sukūrimo ir atnaujinimo datos
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
