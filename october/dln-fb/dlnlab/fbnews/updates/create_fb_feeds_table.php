<?php namespace DLNLab\FBNews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateFbFeedsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_fbnews_fb_feeds', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('fb_id')->index();
            $table->string('object_id')->nullable();
            $table->integer('category_id')->unsigned()->nullable()->index();
            $table->string('type', 20)->nullable();
            $table->string('picture', 500)->nullable();
            $table->string('source', 500)->nullable();
            $table->string('message')->nullable();
            $table->integer('like_count')->default(0)->nullable();
            $table->integer('comment_count')->default(0)->nullable();
            $table->integer('share_count')->default(0)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_fbnews_fb_feeds');
    }

}
