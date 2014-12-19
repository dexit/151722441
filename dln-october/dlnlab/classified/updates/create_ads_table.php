<?php

namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdsTable extends Migration {

	public function up() {
		Schema::create('dlnlab_classified_ads', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('slug')->index();
			$table->text('description')->nullable();
			$table->float('price')->nullable()->default(0);
			$table->timestamp('expiration')->nullable();
			$table->string('address')->nullable();
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->integer('category_id')->unsigned()->nullable()->index();
			$table->integer('country_id')->unsigned()->nullable()->index();
			$table->integer('state_id')->unsigned()->nullable()->index();
			$table->decimal('latitude', 10, 6)->nullable();
			$table->decimal('longtitude', 10, 6)->nullable();
			$table->timestamp('published_at')->nullable();
			$table->tinyInteger('status')->default(0);
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('dlnlab_classified_ads');
	}

}