<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('blog_category_id');
            $table->integer('blog_sub_category_id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('image');
            $table->text('content');
            $table->text('meta_title');
            $table->text('meta_key');
            $table->text('tag');
            $table->text('meta_description');
            $table->tinyInteger('status')->comment('1: active, 0: inactive')->default(1);
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
        Schema::dropIfExists('blogs');
    }
}
