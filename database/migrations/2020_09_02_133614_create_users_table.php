<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            if (!Schema::hasTable('users')) {
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('first_name', 50);
			$table->string('last_name', 50)->nullable();
			$table->string('email')->unique('email');
			$table->bigInteger('mobile_no')->nullable();
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('image_path')->nullable();
			$table->enum('gender', array('M','F'))->nullable()->default('M');
			$table->integer('department_id')->unsigned()->index('fk_users_2_idx');
			$table->integer('role_id')->unsigned()->index('fk_users_1_idx');
			$table->integer('city_id')->unsigned()->index('fk_users_3_idx');
			$table->integer('state_id')->unsigned()->index('fk_users_4_idx');
                        $table->integer('country_id')->unsigned()->index('fk_users_5_idx');
			$table->char('pin_code', 6)->nullable();
			$table->dateTime('activated_at')->nullable();
			$table->enum('is_active', array('0','1'))->default('0')->comment('1-> active 0-> Inactive');
			$table->string('password')->nullable();
			$table->string('hash_passcode')->nullable();
			$table->bigInteger('alt_mobile_no')->nullable();
			$table->integer('created_by');
                        $table->rememberToken();
			$table->timestamps();
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
		Schema::drop('users');
	}

}
