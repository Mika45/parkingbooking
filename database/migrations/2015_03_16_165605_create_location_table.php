<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('LOCATION', function(Blueprint $table)
		{
			$table->increments('location_id');
			$table->string('name', 50);
			$table->string('status', 1)->nullable();
			$table->integer('location_parent_id')->nullable();
			$table->float('lat', 10, 6)->nullable();
			$table->float('lng', 10, 6)->nullable();
			$table->string('currency', 5)->nullable();
			$table->string('currency_order', 1)->nullable();
			$table->text('description')->nullable();
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
		Schema::drop('LOCATION');
	}

}
