<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSendEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_send_emails')) {
                Schema::create('user_send_emails', function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('user_id')->unsigned()->index('user_id');
                    $table->text('token', 65535)->nullable();
                    $table->string('email_template', 100)->nullable();
                    //$table->timestamps();
                    $table->datetime('created_at')->useCurrent();
                    $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

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
        Schema::dropIfExists('user_send_emails');
    }
}
