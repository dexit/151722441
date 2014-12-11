<?php

namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdsCategoriesTable extends Migration {

	public function up() {
		Schema::create('dlnlab_classified_ads_categories', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
			$table->string('slug')->index();
			$table->text('description')->nullable();
			$table->integer('count')->default(0);
			$table->timestamps();
		});
	}

	public function down() {
		Schema::dropIfExists('dlnlab_classified_ads_categories');
	}

}
