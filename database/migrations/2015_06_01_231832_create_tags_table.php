<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('TAG', function(Blueprint $table)
		{
			$table->increments('tag_id');
			$table->string('name');
			$table->string('icon_filename');
			$table->timestamps();
		});

		Schema::create('PARKING_TAG', function(Blueprint $table)
		{
			$table->integer('parking_id')->unsigned()->index();
			$table->foreign('parking_id')->references('parking_id')->on('PARKING')->onDelete('cascade');
			$table->integer('tag_id')->unsigned()->index();
			$table->foreign('tag_id')->references('tag_id')->on('TAG')->onDelete('cascade');
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
		Schema::drop('PARKING_TAG');
		Schema::drop('TAG');
	}

}
