<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('business_id');
            $table->string('image');
            $table->string('address');
            $table->decimal('lat');
            $table->decimal('lon');
            $table->text('overview');
            $table->text('amenities');
            $table->text('near_by');
            $table->string('contact_person');
            $table->string('contact_email');
            $table->string('contact_phone');
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
        Schema::dropIfExists('properties');
    }
}
