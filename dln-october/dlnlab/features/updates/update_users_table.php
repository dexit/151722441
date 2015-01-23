<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->string('fb_uid')->nullable();
            $table->boolean('is_validated')->default(false);
			$table->string('phone_number', 18)->nullable();
            $table->decimal('money_charge', 14, 0)->nullable()->default(0);
            $table->decimal('money_spent', 14, 0)->nullable()->default(0);
            $table->boolean('crawl')->default(false);
        });
    }

    public function down()
    {
        /*Schema::table('users', function($table)
        {
            $table->dropColumn('fb_uid');
            $table->dropColumn('is_validated');
			$table->dropColumn('phone_number');
            $table->dropColumn('money_charge');
            $table->dropColumn('money_spent');
            $table->dropColumn('crawl');
        });*/
    }

}
