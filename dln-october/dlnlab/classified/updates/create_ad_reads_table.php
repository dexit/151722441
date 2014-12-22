<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAdReadsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_ad_reads', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
			$table->integer('ad_id')->unsigned()->nullable()->index();
			$table->integer('count')->default(0);
			$table->integer('total_count')->default(0);
			$table->string('log')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_ad_reads');
    }

}
