<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('TRANSLATION', function(Blueprint $table)
		{
			$table->increments('translation_id');
			$table->string('locale', 2);
			$table->string('column_name', 50);
			$table->text('value')->nullable();
			$table->string('table_name', 50);
			$table->string('identifier', 50);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('TRANSLATION');
	}

}
