<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdSharesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_ad_shares', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('link', 500)->nullable();
			$table->string('md5', 500)->nullable();
            $table->string('fb_id', 50)->nullable();
            $table->integer('count_like')->default(0);
            $table->integer('count_comment')->default(0);
            $table->text('log')->nullable();
            $table->boolean('is_read')->default(false);
            $table->boolean('status')->default(true);
            $table->boolean('crawl')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_shares');
    }

}
