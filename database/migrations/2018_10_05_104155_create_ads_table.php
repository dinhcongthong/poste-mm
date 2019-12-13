<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('position_id');
            $table->unsignedInteger('customer_id');
            $table->string('utm_campaign')->unique();
            $table->unsignedInteger('image');
            $table->string('description');
            $table->string('link');
            $table->unsignedInteger('city_id')->default(0);
            $table->unsignedInteger('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('note')->nullable();
            $table->boolean('inform_sale')->default(true);
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
        Schema::dropIfExists('ads');
    }
}
