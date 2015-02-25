<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdInforsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_ad_infors', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ad_id')->unsigned()->nullable()->index();
            $table->integer('area')->default(0);
            $table->integer('tier')->default(0);
            $table->integer('bath_room')->default(0);
            $table->integer('bed_room')->default(0);
            $table->integer('direction')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_infors');
    }

}
