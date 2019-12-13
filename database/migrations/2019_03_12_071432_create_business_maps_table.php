<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('business_id');
            $table->text('address');
            $table->text('route_guide')->nullable();
            $table->text('map');
            $table->unsignedInteger('image_route_guide')->default(0);
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
        Schema::dropIfExists('business_maps');
    }
}
