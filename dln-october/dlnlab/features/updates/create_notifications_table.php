<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateNotificationsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_notifications', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->string('type', 20)->nullable()->index();
			$table->string('content', 255)->nullable();
			$table->tinyInteger('read', 1)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_notifications');
    }

}
