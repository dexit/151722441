<?php namespace DLNLab\Features\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function($table)
        {
            $table->boolean('is_validated')->default(false);
			$table->string('phone_number', 18)->nullabled();
        });
    }

    public function down()
    {
        Schema::table('users', function($table)
        {
            $table->dropColumn('is_validated');
			$table->dropColumn('phone_number');
        });
    }

}
