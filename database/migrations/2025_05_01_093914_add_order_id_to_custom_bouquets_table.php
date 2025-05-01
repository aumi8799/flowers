<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('custom_bouquets', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('id');
    
            // Jei nori ryšio:
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_bouquets', function (Blueprint $table) {
            //
        });
    }
};
