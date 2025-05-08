<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('loyalty_points', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id')->nullable()->after('user_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('loyalty_points', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropColumn('order_id');
        });
    }    
};
