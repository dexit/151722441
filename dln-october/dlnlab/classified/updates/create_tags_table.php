<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTagsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_tags', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->string('name');
			$table->string('slug')->index();
			$table->integer('parent')->default(0);
			$table->string('desc', 500)->nullable();
			$table->string('type', 100)->nullable();
			$table->string('icon', 20)->nullable();
			$table->integer('count')->default(0);
			$table->boolean('status')->default(false);
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
        Schema::dropIfExists('dlnlab_classified_tags');
		Schema::dropIfExists('dlnlab_classified_ads_tags');
    }

}
