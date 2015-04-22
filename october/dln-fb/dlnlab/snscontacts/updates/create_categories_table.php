<?php namespace DLNLab\SNSContacts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateCategoriesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_snscontacts_categories', function($table)
        {
            $table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
			$table->string('slug')->index();
			$table->text('description')->nullable();
			$table->integer('count')->default(0);
			$table->tinyInteger('status')->default(0);
			$table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_snscontacts_categories');
    }

}
