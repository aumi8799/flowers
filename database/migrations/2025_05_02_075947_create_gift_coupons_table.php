<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gift_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // unikalus kupono kodas
            $table->decimal('value', 8, 2);   // kupono vertė (pvz., 10.00)
            $table->boolean('used')->default(false); // ar kuponas panaudotas
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null'); // ryšys su užsakymu
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_coupons');
    }
};
