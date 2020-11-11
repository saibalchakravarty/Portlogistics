<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToJwtTokenTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('jwt_token', function(Blueprint $table)
		{
			$table->foreign('user_id', 'fk_jwt_token_1')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('jwt_token', function(Blueprint $table)
		{
			$table->dropForeign('fk_jwt_token_1');
		});
	}

}
