<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessSignupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_signups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternate_mobile')->nullable();
            $table->text('company_website')->nullable();
            $table->text('address')->nullable();
            $table->text('postcode')->nullable();
            $table->integer('business_lead_id')->nullable();
            $table->text('opening_hour')->nullable();
            $table->text('social')->nullable();
            $table->text('meta_description')->nullable();

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
        Schema::dropIfExists('business_signups');
    }
}
