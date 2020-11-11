<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVesselsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vessels', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->decimal('loa', 6)->nullable();
			$table->decimal('beam', 6)->nullable();
			$table->decimal('draft', 6)->nullable();
			$table->text('description', 65535)->nullable();
			$table->datetime('created_at')->useCurrent();
			$table->integer('created_by');
			$table->integer('updated_by')->nullable();
			$table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
			
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vessels');
	}

}
