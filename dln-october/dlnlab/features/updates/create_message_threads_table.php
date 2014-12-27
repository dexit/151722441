<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMessageMessagesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_message_threads', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
			$table->bigInteger('thread_id')->unsigned()->nullable();
			$table->integer('sender_id')->nullable();
			$table->text('message')->nullable();
            $table->timestamp('created_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_message_threads');
    }

}
