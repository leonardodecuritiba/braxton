<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlertLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alert_logs', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('alert_id');
	        $table->foreign('alert_id')->references('id')->on('alerts')->onDelete('cascade');

	        $table->string('data',1000);
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
        Schema::dropIfExists('alert_logs');
    }
}
