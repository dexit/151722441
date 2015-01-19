<?php

namespace DLNLab\Classified\Updates;

use DB;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdTable extends Migration {

	public function up() {
		Schema::create('dlnlab_classified_ads', function($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name')->nullable();
			$table->string('slug')->index();
			$table->text('desc')->nullable();
            $table->string('full_text', 500)->nullable();
			$table->decimal('price', 14, 0)->nullable()->default(0);
			$table->timestamp('expiration')->nullable();
			$table->string('address')->nullable();
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->integer('category_id')->unsigned()->nullable()->index();
			$table->decimal('lat', 10, 6)->nullable();
			$table->decimal('lng', 10, 6)->nullable();
			$table->timestamp('published_at')->nullable();
			$table->tinyInteger('status')->default(0);
			$table->integer('read')->default(0);
			$table->timestamps();
		});
        //DB::statement('ALTER TABLE `dlnlab_classified_ads` ADD FULLTEXT(`full_text`);');
	}

	public function down() {
		Schema::dropIfExists('dlnlab_classified_ads');
	}

}
