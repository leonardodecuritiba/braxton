<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDashboardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboards', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedInteger('author_id');
	        $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
	        $table->unsignedInteger('client_id');
	        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
	        $table->unsignedInteger('sensor_id');
	        $table->foreign('sensor_id')->references('id')->on('sensors')->onDelete('cascade');

	        $table->unsignedTinyInteger('size')->default(0);
	        $table->string('color',7);
	        $table->string('bullet',20);
	        $table->string('format',20);
	        $table->tinyInteger('period');
	        $table->boolean('active')->default(1);

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
        Schema::dropIfExists('dashboards');
    }
}
