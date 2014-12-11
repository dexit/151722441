<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePincodesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_pincodes', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->integer('user_id')->unsigned()->nullable()->index();
			$table->integer('code')->unsigned()->nullable()->index();
			$table->string('phone_number')->nullabled();
			$table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_pincodes');
    }

}
