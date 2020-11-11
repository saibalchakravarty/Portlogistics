<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('cities')) {
		Schema::create('cities', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('city', 150);
			$table->integer('state_id')->unsigned()->index('state_id');
		});
            }    
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cities');
	}

}
