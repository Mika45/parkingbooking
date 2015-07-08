<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('USER', function(Blueprint $table)
		{
			$table->increments('user_id');
			$table->string('email', 50)->unique();
			$table->string('password', 60);
			$table->string('title', 5);
			$table->string('firstname', 50);
			$table->string('lastname', 50);
			$table->string('mobile', 30)->nullable();
			$table->string('car_make', 50)->nullable();
			$table->string('car_model', 50)->nullable();
			$table->string('car_reg', 50)->nullable();
			$table->string('car_colour', 50)->nullable();
			$table->string('newsletter', 1)->nullable();
			$table->datetime('lastlogin')->nullable();
			$table->string('status', 1)->nullable();
			$table->string('activation_code')->nullable();
			$table->integer('attempts')->nullable();
			$table->string('lang', 20)->nullable();
			$table->string('is_admin', 1)->nullable();
			$table->string('is_affiliate', 1)->nullable();
			$table->integer('discount')->nullable();
			$table->rememberToken();
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
		Schema::drop('USER');
	}

}
