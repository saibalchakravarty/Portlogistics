<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJwtTokenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jwt_token', function(Blueprint $table)
		{
			$table->increments('id');
			$table->text('token', 65535);
			$table->integer('user_id')->unsigned()->index('user_id');
			$table->bigInteger('mobile_number')->nullable();
			$table->smallInteger('expiry_time');
			$table->text('device_token', 65535)->nullable();
			$table->char('device_type', 10)->nullable();
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
		Schema::drop('jwt_token');
	}

}
