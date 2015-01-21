<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdSharePagesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_ad_share_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('fb_id')->nullable();
            $table->integer('like')->default(0);
            $table->integer('talking_about')->default(0);
            $table->text('access_token')->nullable();
            $table->integer('count')->default(0);
            $table->boolean('status')->default(true);
            $table->boolean('crawl')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_share_pages');
    }

}
