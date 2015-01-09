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
			$table->decimal('money', 14, 0)->nullable()->default(0);
			$table->string('type', 50)->default('basic');
			$table->boolean('crawl')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_money');
    }

}
