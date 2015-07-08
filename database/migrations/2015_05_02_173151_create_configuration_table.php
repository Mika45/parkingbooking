<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('CONFIGURATION', function(Blueprint $table)
		{
			$table->integer('parking_id');
			$table->string('conf_name', 50);
			$table->string('value', 50);
			// PK
			$table->primary(array('parking_id', 'conf_name'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('CONFIGURATION');
	}

}
