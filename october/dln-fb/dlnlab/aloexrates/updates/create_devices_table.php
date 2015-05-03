<?php namespace DLNLab\AloExrates\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateDevicesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_aloexrates_devices', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('device_id')->nullable()->index();
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_aloexrates_devices');
    }

}
