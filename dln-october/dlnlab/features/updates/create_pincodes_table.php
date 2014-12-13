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
			$table->string('code', 5)->nullable();
			$table->string('phone_number', 18)->nullabled();
			$table->tinyInteger('status')->default(0);
			$table->string('error', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_pincodes');
    }

}
