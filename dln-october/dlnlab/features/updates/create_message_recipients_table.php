<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMessageRecipientsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_message_recipients', function($table)
        {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
			$table->integer('user_id')->nullable();
			$table->bigInteger('thread_id')->nullable();
			$table->integer('unread_count')->default(0);
			$table->boolean('is_sender')->default(false);
			$table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_message_recipients');
    }

}
