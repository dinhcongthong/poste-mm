<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->string('english_name')->nullable();
            $table->string('address')->nullable();
            $table->text('route_guide')->nullable();
            $table->string('img_route_guide')->nullable();
            $table->unsignedInteger('city_id')->default(0);
            $table->text('description');
            $table->string('phone')->nullable();
            $table->string('repre_phone')->nullable();
            $table->string('email')->nullable();
            $table->unsignedInteger('thumb_id')->default(0);
            $table->text('representator')->nullable();
            $table->date('founding_date')->nullable();
            $table->string('employee_number')->nullable();
            $table->text('outline')->nullable();
            $table->text('customer_object')->nullable();
            $table->text('partner')->nullable();
            $table->text('capital')->nullable();
            $table->text('map')->nullable();
            $table->string('website')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('owner_id')->default(0);
            $table->boolean('public_address')->default(true);
            $table->boolean('public_phone')->default(true);
            $table->boolean('public_email')->default(true);

            $table->boolean('fee')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('end_free_date');
            $table->unsignedInteger('status')->default(0);

            $table->string('pdf_url')->nullable();

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
        Schema::dropIfExists('businesses');
    }
}
