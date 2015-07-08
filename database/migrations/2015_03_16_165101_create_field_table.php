<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('FIELD', function(Blueprint $table)
		{
			$table->increments('field_id');
			$table->string('field_name', 50);
			$table->string('type', 50)->nullable();
			$table->text('attributes', 20)->nullable();
			$table->string('label', 50)->nullable();
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
		Schema::drop('FIELD');
	}

}
