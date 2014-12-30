<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCrawlLinksTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_crawl_links', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('type', 50)->nullable();
			$table->string('link', 500)->nullable();
			$table->string('md5', 500)->nullable();
			$table->integer('crawl')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_crawl_links');
    }

}
