<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateRewardsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_rewards', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->integer('code')->unsigned()->nullable()->index();
			$table->string('type')->nullable()->default('friend');
			$table->float('credit')->nullable()->default(0);
			$table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_rewards');
    }

}
