<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateBitliesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_features_bitlies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('link', 500)->nullable();
			$table->string('md5', 500)->nullable();
            $table->string('bit_link', 50);
            $table->string('hash', 50);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_features_bitlies');
    }

}
