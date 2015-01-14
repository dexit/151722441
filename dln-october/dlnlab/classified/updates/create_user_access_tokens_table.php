<?php namespace DLNLab\Classified\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateUserAccessTokensTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_classified_user_access_tokens', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->text('access_token')->nullable();
            $table->boolean('expire')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_classified_user_access_tokens');
    }

}
