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
            $table->integer('count')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_share_pages');
    }

}
