<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Padaryti product_id pasirinktiniu
            $table->unsignedBigInteger('product_id')->nullable()->change();

            // Pridėti custom_bouquet_id
            $table->foreignId('custom_bouquet_id')->nullable()->constrained()->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Atkurti product_id kaip neprivalomą (jei reikia)
            $table->unsignedBigInteger('product_id')->nullable(false)->change();

            // Pašalinti custom_bouquet_id
            $table->dropForeign(['custom_bouquet_id']);
            $table->dropColumn('custom_bouquet_id');
        });
    }
};
