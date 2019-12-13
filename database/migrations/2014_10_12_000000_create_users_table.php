<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name');
            $table->string('kata_first_name')->nullable();
            $table->string('kata_last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->unsignedInteger('type_id')->default(3);
            $table->unsignedInteger('gender_id')->default(0);
            $table->date('birthday')->nullable();
            $table->unsignedInteger('occupation_id')->default(0);
            $table->string('phone')->nullable();
            $table->unsignedInteger('secret_question_id')->default(0);
            $table->string('answer')->nullable();
            $table->boolean('is_news_letter')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
