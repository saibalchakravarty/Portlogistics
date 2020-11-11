<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTruckCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('truck_companies', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 200);		
			$table->string('email',191)->nullable();
			$table->bigInteger('mobile_no')->nullable();
			$table->string('contact_name', 100)->nullable();
			$table->bigInteger('contact_mobile_no')->nullable();
			$table->enum('is_active', array('0','1'))->default('1')->comment('1-> active 0-> Inactive');
			$table->datetime('created_at')->useCurrent();
                        $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('truck_companies');
	}

}
