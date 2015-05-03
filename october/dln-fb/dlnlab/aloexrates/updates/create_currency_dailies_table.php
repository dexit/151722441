<?php namespace DLNLab\AloExrates\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCurrencyDailiesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_aloexrates_currency_dailies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('currency_id')->nullable();
            $table->integer('price')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_aloexrates_currency_dailies');
    }

}
