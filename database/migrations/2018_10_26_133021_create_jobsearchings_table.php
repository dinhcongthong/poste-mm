<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsearchingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobsearchings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug');
            $table->string('name');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('category_id');
            $table->text('content')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('show_phone_num');
            $table->string('address')->nullable();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('approver_id')->default(0);
            $table->unsignedInteger('nationality');
            $table->unsignedInteger('quantity');
            $table->text('requirement')->nullable();
            $table->string('salary');
            $table->text('other_info')->nullable();
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
        Schema::dropIfExists('jobsearchings');
    }
}
