<?php namespace DLNLab\FBNews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateFbPagesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_fbnews_fb_pages', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('fb_id')->nullable();
            $table->integer('category_id')->unsigned()->nullable()->index();
            $table->integer('like_count')->default(0);
            $table->integer('talking_about')->default(0);
            $table->string('type', 10)->default('page');
            $table->integer('count')->default(0);
            $table->boolean('status')->default(false);
            $table->boolean('crawl')->default(false);
            $table->boolean('crawl_fb')->default(false);
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_fbnews_fb_pages');
    }

}
