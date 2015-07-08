<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingFieldTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PARKING_FIELD', function(Blueprint $table)
		{
			$table->integer('parking_id');
			$table->integer('field_id');
			$table->string('required', 1);
			$table->timestamps();
			// PK
			$table->primary(array('parking_id', 'field_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('PARKING_FIELD');
	}

}
