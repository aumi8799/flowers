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
        Schema::table('postcards', function (Blueprint $table) {
            $table->unsignedBigInteger('order_item_id')->nullable()->after('order_id');
            $table->foreign('order_item_id')->references('id')->on('order_items')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('postcards', function (Blueprint $table) {
            //
        });
    }
};
