<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('businesses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('category_id');
			$table->integer('sub_category_id');
			$table->string('name');
			$table->string('street_no');
			$table->string('street_name');
			$table->integer('city_id');
			$table->integer('state_id');
			$table->integer('country_id');
			$table->integer('zipcode');
			$table->string('lat');
			$table->string('lon');
			$table->string('phone');
			$table->string('website');
			$table->float('rating');
			$table->integer('no_of_ratings');
			$table->integer('sponsored');
			$table->integer('status');
			$table->string('slug');
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
		Schema::drop('businesses');
	}

}
