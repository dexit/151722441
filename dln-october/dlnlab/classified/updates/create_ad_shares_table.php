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
            $table->integer('ad_id')->nullable();
            $table->string('link', 500)->nullable();
            $table->string('share_id', 50)->nullable();
            $table->string('share_type', 20)->nullable();
            $table->integer('count_like')->default(0);
            $table->integer('count_comment')->default(0);
            $table->integer('total_count')->default(0);
            $table->boolean('is_read')->default(false);
            $table->tinyInteger('status')->default(0);
            $table->boolean('crawl')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_shares');
    }

}
