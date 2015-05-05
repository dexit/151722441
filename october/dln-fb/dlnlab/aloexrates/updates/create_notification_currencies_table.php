<?php namespace DLNLab\AloExrates\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateNotificationCurrenciesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_aloexrates_notification_currencies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('notification_id')->index();
            $table->integer('currency_id')->index();
            $table->boolean('is_send')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_aloexrates_notification_currencies');
    }

}
