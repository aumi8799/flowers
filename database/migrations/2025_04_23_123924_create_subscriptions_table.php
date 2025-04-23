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
       // database/migrations/xxxx_xx_xx_create_subscriptions_table.php
            Schema::create('subscriptions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('category'); // pvz. "rožės"
                $table->string('size'); // S / M / L
                $table->integer('duration'); // mėnesių skaičius
                $table->decimal('price', 8, 2);
                $table->date('start_date')->nullable(); // nuo kada vykdyti
                $table->string('status')->default('aktyvi'); // aktyvi, sustabdyta, baigta
                $table->timestamps();
            });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
