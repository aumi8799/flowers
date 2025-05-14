<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDecorationOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('decoration_orders', function (Blueprint $table) {
            $table->id();
            $table->date('event_date');
            $table->string('location');
            $table->integer('guests_count')->nullable();
            $table->integer('tables_count')->nullable();
            $table->string('flowers')->nullable();
            $table->string('color_scheme')->nullable();
            $table->string('style')->nullable();
            $table->decimal('budget', 8, 2);
            $table->string('name');
            $table->string('email');
            $table->text('comments')->nullable();
            $table->string('package');
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('decoration_orders');
    }
}
