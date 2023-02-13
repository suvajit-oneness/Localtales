<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('image');
            $table->string('address');
            $table->decimal('lat',10,6);
            $table->decimal('lon',10,6);
            $table->date('expiry_date');
            $table->text('short_description');
            $table->text('description');
            $table->integer('category_id');
            $table->integer('business_id');
            $table->string('price');
            $table->string('promo_code');
            $table->text('how_to_redeem');
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
        Schema::dropIfExists('deals');
    }
}
