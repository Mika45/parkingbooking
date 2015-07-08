<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingLocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PARKING_LOCATION', function(Blueprint $table)
		{
			$table->integer('parking_id');
			$table->integer('location_id');
			$table->string('status', 1);
			$table->timestamps();
			// PK
			$table->primary(array('parking_id', 'location_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('PARKING_LOCATION');
	}

}
