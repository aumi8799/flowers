<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_bouquets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // jei vartotojas prisijungęs
            $table->json('bouquet_data'); // pasirinktų gėlių sąrašas
            $table->decimal('total_price', 8, 2); // bendra puokštės kaina
            $table->timestamps(); // created_at ir updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_bouquets');
    }
};
