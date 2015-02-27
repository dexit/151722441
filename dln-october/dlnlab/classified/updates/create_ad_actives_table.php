<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdActivesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_ad_actives', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->integer('ad_id')->unsigned()->nullable()->index();
			$table->decimal('money', 14, 0)->nullable()->default(0);
            $table->decimal('money_bonus', 14, 0)->nullable()->default(0);
            $table->timestamp('start_date')->nullable();
			$table->timestamp('end_date')->nullable();
			$table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_actives');
    }

}
