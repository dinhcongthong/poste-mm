<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTownWorktimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('town_worktimes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('town_id');
            $table->unsignedInteger('day_on_week');
            $table->time('open_time');
            $table->time('close_time');
            $table->boolean('off_day')->default(false);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('town_worktimes');
    }
}
