<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRealestateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('realestates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('price_id');
            $table->text('content')->nullable();
            $table->unsignedInteger('city_id')->default(0);
            $table->unsignedInteger('district_id')->default(0);
            $table->unsignedInteger('first_image');
            $table->unsignedInteger('second_image');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('show_phone_num');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('approver_id')->default(0);
            $table->unsignedInteger('bedroom_id');
            $table->boolean('full_furniture');
            $table->boolean('internet');
            $table->boolean('bathtub');
            $table->boolean('pool');
            $table->boolean('gym');
            $table->boolean('electronic');
            $table->boolean('television');
            $table->boolean('kitchen');
            $table->boolean('garage');
            $table->boolean('security');
            $table->softDeletes();
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
        Schema::dropIfExists('realestates');
    }
}
