<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pridedame lauką used_in_order_id, kad galėtume susieti, kuriame užsakyme buvo panaudotas kuponas.
     */
    public function up(): void
    {
        Schema::table('gift_coupons', function (Blueprint $table) {
            $table->unsignedBigInteger('used_in_order_id')->nullable()->after('used');

            // (neprivaloma, bet naudinga) užtikriname duomenų vientisumą su foreign key
            $table->foreign('used_in_order_id')->references('id')->on('orders')->onDelete('set null');
        });
    }

    /**
     * Pašaliname lauką jei migracija atsukama atgal.
     */
    public function down(): void
    {
        Schema::table('gift_coupons', function (Blueprint $table) {
            $table->dropForeign(['used_in_order_id']);
            $table->dropColumn('used_in_order_id');
        });
    }
};
