<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSearchUsersTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_search_users', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('title');
			$table->integer('search_id')->unsigned()->nullable()->index();
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->integer('last_search_count')->default(0);
			$table->tinyInteger('is_readed')->default(0);
			$table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_search_users');
    }

}
