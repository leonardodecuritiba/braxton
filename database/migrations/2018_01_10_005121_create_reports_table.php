<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
	        $table->increments('id');
	        $table->unsignedInteger('author_id');
	        $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
	        $table->unsignedInteger('client_id');
	        $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
	        $table->unsignedInteger('sensor_id');
	        $table->foreign('sensor_id')->references('id')->on('sensors')->onDelete('cascade');

	        $table->string('name', 100);
	        $table->tinyInteger('repetition');
	        $table->string('repetition_option',20)->nullable();
	        $table->string('interval', 30)->nullable();
	        $table->dateTime('execution_at');
	        $table->string('time', 20)->nullable();
	        $table->boolean('send_email')->default(1);
	        $table->string('main_email', 100)->nullable();
	        $table->string('copy_email', 500)->nullable();

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
        Schema::dropIfExists('reports');
    }
}
