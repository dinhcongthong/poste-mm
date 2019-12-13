<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->text('keywords');
            $table->string('description');
            $table->unsignedInteger('tag')->default(0);
            $table->unsignedInteger('thumb_id');
            $table->unsignedInteger('city_id');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('related_ids')->nullable();
            $table->date('published_at')->nullable();
            $table->unsignedInteger('view')->default(0);
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('user_id');
            $table->text('author')->nullable();

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
        Schema::dropIfExists('news');
    }
}
