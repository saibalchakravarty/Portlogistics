<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTrucksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('trucks', function(Blueprint $table)
		{
			$table->foreign('truck_company_id', 'fk_trucks_1')->references('id')->on('truck_companies')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('trucks', function(Blueprint $table)
		{
			$table->dropForeign('fk_trucks_1');
		});
	}

}
