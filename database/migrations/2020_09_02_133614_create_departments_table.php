<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('departments')) {
		Schema::create('departments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->enum('is_active', array('0','1'))->default('1')->comment('1-> active 0-> Inactive');
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
		Schema::drop('departments');
	}

}
