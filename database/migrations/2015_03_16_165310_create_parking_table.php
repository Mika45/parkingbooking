<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('PARKING', function(Blueprint $table)
		{
			$table->increments('parking_id');
			$table->string('parking_name', 50);
			$table->string('status', 1);
			$table->integer('slots');
			$table->string('rate_type', 1);
			$table->integer('min_duration')->nullable();
			$table->integer('early_booking')->nullable();
			$table->text('description')->nullable();
			$table->text('find_it')->nullable();
			$table->integer('image_count')->nullable();
			$table->string('address', 50)->nullable();
			$table->text('reserve_notes')->nullable();
			$table->string('gmaps', 2000)->nullable();
			$table->float('lat', 10, 6)->nullable();
			$table->float('lng', 10, 6)->nullable();
			$table->string('timezone', 50)->nullable();
			$table->string('non_work_hours')->nullable();
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
		Schema::drop('PARKING');
	}

}
