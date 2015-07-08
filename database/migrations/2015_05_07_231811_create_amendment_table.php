<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmendmentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('AMENDMENT', function(Blueprint $table)
		{
			$table->increments('amend_id');
			$table->integer('booking_id');
			$table->integer('parking_id')->nullable();
			$table->datetime('checkin_old')->nullable();
			$table->datetime('checkout_old')->nullable();
			$table->decimal('price_old', 8, 2);
			$table->datetime('checkin_new')->nullable();
			$table->datetime('checkout_new')->nullable();
			$table->decimal('price_new', 8, 2)->nullable();
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
		Schema::drop('AMENDMENT');
	}

}
