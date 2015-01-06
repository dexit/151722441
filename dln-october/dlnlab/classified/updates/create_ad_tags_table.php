<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdTagsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_ad_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('name');
			$table->string('slug')->index();
			$table->text('description')->nullable();
			$table->string('type', 100)->nullable();
			$table->integer('count')->default(0);
            $table->timestamps();
        });
		
		Schema::create('dlnlab_classified_ads_tags', function($table)
        {
            $table->engine = 'InnoDB';
			$table->integer('ad_id')->unsigned();
			$table->integer('tag_id')->unsigned();
            $table->primary(['ad_id', 'tag_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_tags');
		Schema::dropIfExists('dlnlab_classified_ads_tags');
    }

}
