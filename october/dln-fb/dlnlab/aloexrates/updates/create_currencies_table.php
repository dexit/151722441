<?php namespace DLNLab\AloExrates\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCurrenciesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_aloexrates_currencies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code', '25')->index();
            $table->string('type', 10)->default('CURRENCY');
            $table->string('name', '25')->nullable();
            $table->string('flag', '25')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('crawl')->default(false);
            $table->boolean('is_send')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_aloexrates_currencies');
    }

}
