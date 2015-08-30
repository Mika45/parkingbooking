<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddParkingPhoneColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('PARKING', function ($table) {
		    $table->string('phone1')->nullable();
		    $table->string('phone2')->nullable();
		    $table->string('mobile')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('PARKING', function ($table) {
		    $table->dropColumn('phone1');
		    $table->dropColumn('phone2');
		    $table->dropColumn('mobile');
		});
	}

}
