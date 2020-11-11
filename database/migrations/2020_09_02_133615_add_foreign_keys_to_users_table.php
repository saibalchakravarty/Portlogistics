<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->foreign('role_id', 'fk_users_1')->references('id')->on('user_roles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('department_id', 'fk_users_2')->references('id')->on('departments')->onUpdate('NO ACTION')->onDelete('NO ACTION');
                        $table->foreign('country_id', 'fk_users_3')->references('id')->on('countries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
                        $table->foreign('state_id', 'fk_users_4')->references('id')->on('states')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('city_id', 'fk_users_5')->references('id')->on('cities')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropForeign('fk_users_1');
			$table->dropForeign('fk_users_2');
			$table->dropForeign('fk_users_3');
			$table->dropForeign('fk_users_4');
			$table->dropForeign('fk_users_5');
		});
	}

}
