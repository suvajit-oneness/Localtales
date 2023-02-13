<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('image');
            $table->string('address');
            $table->decimal('lat',10,6);
            $table->decimal('lon',10,6);
            $table->string('pin');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('start_time');
            $table->string('end_time');
            $table->text('description');
            $table->integer('category_id');
            $table->integer('business_id');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('website');
            $table->integer('language_id');
            $table->integer('format_id');
            $table->integer('is_paid')->default(0);
            $table->double('price',8,2);
            $table->integer('is_recurring')->default(0);
            $table->integer('no_of_followers')->default(0);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
