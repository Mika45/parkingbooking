<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('BOOKING', function(Blueprint $table)
		{
			$table->increments('booking_id');
			$table->string('booking_ref', 10)->unique();
			$table->integer('user_id')->nullable();
			$table->integer('parking_id');
			$table->datetime('checkin');
			$table->datetime('checkout');
			$table->decimal('price', 8, 2);
			$table->string('title', 5);
			$table->string('firstname', 50);
			$table->string('lastname', 50);
			$table->string('mobile', 30);
			$table->string('email', 50);
			$table->string('car_make', 50);
			$table->string('car_model', 50);
			$table->string('car_reg', 50);
			$table->string('car_colour', 50)->nullable();
			$table->integer('passengers')->nullable();
			$table->string('status', 20)->nullable();
			$table->string('newsletter', 1)->nullable();
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
		Schema::drop('BOOKING');
	}

}
