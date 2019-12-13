<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonaltradingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personaltradings', function (Blueprint $table) {
            $table->increments('id');
            $table->text('slug');
            $table->text('name');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('category_id');
            $table->string('price');
            $table->unsignedInteger('delivery_method')->default(0);
            $table->text('content')->nullable();
            $table->string('address');
            $table->unsignedInteger('first_image')->default(0);
            $table->unsignedInteger('second_image')->default(0);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('show_phone_num')->default(0);
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('approver_id')->default(0);
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
        Schema::dropIfExists('personaltradings');
    }
}
