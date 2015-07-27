<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserSettings extends Migration {

	/*
		Used Settings Fields Used:
		1)facebook_id
		2)facebook_access_token
		3)twitter_id
		4)twitter_access_token

	*/

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_settings', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->nullable();
			$table->string('setting')->nullable();
			$table->text('value')->nullable();
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
		Schema::drop('user_settings');
	}

}
