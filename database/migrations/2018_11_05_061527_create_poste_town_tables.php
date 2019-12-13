<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosteTownTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poste_towns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->unsignedInteger('avatar');
            // $table->string('tags')->nullable();
            $table->text('description');
            $table->unsignedInteger('city_id');
            $table->string('address');
            $table->string('route_guide')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook')->nullable();
            $table->boolean('fee')->default(0);
            $table->string('map')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id');
            $table->string('credit')->nullable();
            $table->date('end_free_date');
            $table->unsignedInteger('owner_id')->default(0);
            $table->unsignedInteger('status')->default(1);
            $table->unsignedInteger('customer_id')->default(0);

            $table->string('monday')->nullable();
            $table->string('tuesday')->nullable();
            $table->string('wednessday')->nullable();
            $table->string('thursday')->nullable();
            $table->string('friday')->nullable();
            $table->string('saturday')->nullable();
            $table->string('sunday')->nullable();

            $table->string('working_time')->nullable();
            $table->string('regular_close')->nullable();
            $table->string('budget')->nullable();
            $table->string('private_room')->nullable();
            $table->string('smoking')->nullable();
            $table->string('currency')->nullable();
            $table->string('wifi')->nullable();
            $table->string('usage_scenes')->nullable();
            $table->string('service_tax')->nullable();
            
            $table->string('check_in')->nullable();
            $table->string('check_out')->nullable();
            $table->string('laundry')->nullable();
            $table->string('breakfast')->nullable();
            $table->string('shuttle')->nullable();
            $table->string('air_condition')->nullable();
            $table->string('parking')->nullable();
            $table->string('kitchen')->nullable();
            $table->string('tv')->nullable();
            $table->string('shower')->nullable();
            $table->string('bathtub')->nullable();
            $table->string('luggage')->nullable();

            $table->string('insurance')->nullable();
            $table->string('language')->nullable();
            $table->string('department')->nullable();

            $table->string('target_student')->nullable();
            $table->string('object')->nullable();
            $table->string('tuition_fee')->nullable();

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
        Schema::dropIfExists('poste_towns');
    }
}
