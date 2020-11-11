<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('user_roles')) {
		Schema::create('user_roles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->timestamps();
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
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
		Schema::drop('user_roles');
	}

}
