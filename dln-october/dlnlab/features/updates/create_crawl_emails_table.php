<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCrawlEmailsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_crawl_emails', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('email', 100);
			$table->integer('count')->default(0);
			$table->string('own', 50)->nullable()->default('bạn');
			$table->boolean('status')->default(false);
			$table->string('data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_crawl_emails');
    }

}
