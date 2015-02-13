<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdFavoritesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_ad_favorites', function($table)
        {
            $table->engine = 'InnoDB';
			$table->integer('ad_id')->unsigned();
			$table->integer('user_id')->unsigned();
            $table->primary(['ad_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_favorites');
    }

}
