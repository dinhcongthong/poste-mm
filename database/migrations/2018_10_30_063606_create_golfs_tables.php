<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGolfsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('golfs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('keywords');
            $table->unsignedInteger('tag');
            $table->unsignedInteger('thumb_id');
            $table->text('description');
            $table->string('address');
            $table->unsignedInteger('district_id');
            $table->unsignedInteger('city_id');
            $table->string('map')->nullable();
            $table->string('phone');
            $table->string('work_time');
            $table->string('website')->nullable();
            $table->string('budget')->nullable();
            $table->string('yard')->nullable();
            $table->string('caddy')->nullable();
            $table->string('rental')->nullable();
            $table->string('cart')->nullable();
            $table->string('facility')->nullable();
            $table->string('shower')->nullable();
            $table->string('lesson')->nullable();
            $table->string('golf_station_number')->nullable();
            $table->unsignedInteger('user_id');
            $table->boolean('is_draft')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('golfs');
    }
}
