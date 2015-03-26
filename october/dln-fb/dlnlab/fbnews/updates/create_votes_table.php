<?php namespace DLNLab\FBNews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateVotesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_fbnews_devices_votes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('device_id')->nullable();
            $table->string('fb_id')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_fbnews_devices');
    }

}
