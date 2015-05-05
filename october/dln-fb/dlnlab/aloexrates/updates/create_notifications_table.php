<?php namespace DLNLab\AloExrates\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateNotificationsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_aloexrates_notifications', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type', 12)->nullable();
            $table->string('sender_id', 255)->index();
            $table->boolean('is_min')->default(false);
            $table->boolean('is_max')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_aloexrates_notifications');
    }

}
