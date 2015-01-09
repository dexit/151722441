<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSearchesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_searches', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('query', 500)->index();
			$table->integer('crawl')->default(0);
			$table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_searches');
    }

}
