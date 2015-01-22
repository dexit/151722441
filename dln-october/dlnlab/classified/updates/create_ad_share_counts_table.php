<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdShareCountsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_ad_share_counts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ad_id')->nullable();
            $table->integer('bitly_id')->nullable();
            $table->integer('share_count')->default(0);
            $table->integer('comment_count')->default(0);
            $table->integer('like_count')->default(0);
            $table->integer('gp_count')->default(0);
            $table->integer('tw_count')->default(0);
            $table->integer('pin_count')->default(0);
            $table->text('log')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->boolean('crawl')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_share_counts');
    }

}
