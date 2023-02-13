<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateBusinessLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_leads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('bussiness_name');
            $table->bigInteger('category')->nullable();
            $table->longText('service_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('alt_mobile_no')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->string('youtube_link')->nullable();
            $table->string('bussiness_address')->nullable();
            $table->string('monday_opening_hour')->nullable();
            $table->string('tuesday_opening_hour')->nullable();
            $table->string('wednesday_opening_hour')->nullable();
            $table->string('thursday_opening_hour')->nullable();
            $table->string('friday_opening_hour')->nullable();
            $table->string('saturday_opening_hour')->nullable();
            $table->string('sunday_opening_hour')->nullable();
            $table->tinyInteger('type')->comment('1: Single, 2: Multiple')->default(1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }
   
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('business_leads');
    }
}
