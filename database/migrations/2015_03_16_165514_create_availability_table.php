<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailabilityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('AVAILABILITY', function(Blueprint $table)
		{
			$table->integer('parking_id')->index();
			$table->date('date')->index();
			$table->time('time_start')->nullable();
			$table->time('time_end')->nullable();
			$table->integer('slots');
			$table->integer('remaining_slots');
			$table->string('status', 1);
			// PK
			//$table->primary(array('parking_id', 'date', 'time_start'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('AVAILABILITY');
	}

}
