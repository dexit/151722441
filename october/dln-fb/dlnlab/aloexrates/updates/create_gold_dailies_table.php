<?php namespace DLNLab\AloExrates\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateGoldDailiesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_aloexrates_gold_dailies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type', 10)->default('SJC');
            $table->integer('currency_id')->nullable();
            $table->float('buy')->default(0);
            $table->float('sell')->default(0);
            $table->float('min')->default(0);
            $table->float('max')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_aloexrates_gold_dailies');
    }

}
