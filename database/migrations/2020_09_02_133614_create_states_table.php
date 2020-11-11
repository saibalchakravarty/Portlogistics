<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('states')) {
		Schema::create('states', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('state');
                        $table->integer('country_id')->unsigned()->index('country_id');
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
		Schema::drop('states');
	}

}
