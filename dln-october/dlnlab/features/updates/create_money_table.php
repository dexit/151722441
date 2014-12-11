<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateMoneyTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_money', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->float('money')->nullable()->default(0);
			$table->string('type')->nullable()->default('basic');
			$table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_money');
    }

}
