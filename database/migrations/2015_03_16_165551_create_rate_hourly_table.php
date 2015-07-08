<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRateHourlyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('RATE_HOURLY', function(Blueprint $table)
		{
			$table->increments('rate_id');
			$table->integer('parking_id');
			$table->integer('hours');
			$table->decimal('price', 8, 3);
			$table->decimal('discount', 5, 5)->nullable();
			$table->integer('free_mins')->nullable();
			$table->timestamps();
			// PK
			//$table->primary(array('parking_id', 'hours'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('RATE_HOURLY');
	}

}
