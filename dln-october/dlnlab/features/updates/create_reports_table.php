<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateReportsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_reports', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->integer('target_id')->unsigned()->nullable()->index();
			$table->string('content')->nullable();
			$table->string('type', 20)->nullable()->index();
			$table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_reports');
    }

}
