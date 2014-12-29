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
			$table->bigInteger('user_id')->unsigned()->nullable()->index();
			$table->bigInteger('item_id')->nullable();
			$table->bigInteger('item_secondary_item_id')->nullable();
			$table->string('component_name', 50)->nullable();
			$table->string('component_action', 50)->nullable();
			$table->string('type', 20)->nullable()->index();
			$table->boolean('is_new')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_notifications');
    }

}
