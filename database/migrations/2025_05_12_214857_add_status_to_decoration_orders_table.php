<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('decoration_orders', function (Blueprint $table) {
            $table->string('status')->default('pateiktas'); // Galimos reikšmės: pateiktas, žiūrimas, vykdomas, atmestas
        });
    }

    public function down(): void
    {
        Schema::table('decoration_orders', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

