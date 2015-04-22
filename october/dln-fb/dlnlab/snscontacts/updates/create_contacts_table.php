<?php namespace DLNLab\SNSContacts\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateContactsTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_snscontacts_contacts', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('phone', 50)->nullable();
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->integer('category_id')->unsigned()->nullable()->index();
            $table->string('tags', 255)->default(null);
            $table->string('full_text', 500)->nullable();
            $table->integer('loc')->nullable();
            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('lng', 10, 6)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_snscontacts_contacts');
    }

}
