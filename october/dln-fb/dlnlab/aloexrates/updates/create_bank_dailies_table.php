<?php namespace DLNLab\AloExrates\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateBankDailiesTable extends Migration
{

    public function up()
    {
        Schema::create('dlnlab_aloexrates_bank_dailies', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('type', 10)->default('VCB');
            $table->integer('currency_id')->nullable();
            $table->float('buy')->default(0);
            $table->float('transfer')->default(0);
            $table->float('sell')->default(0);
            $table->float('min_buy')->default(0);
            $table->float('max_buy')->default(0);
            $table->float('min_sell')->default(0);
            $table->float('max_sell')->default(0);
            $table->float('buy_change')->default(0);
            $table->float('sell_change')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dlnlab_aloexrates_bank_dailies');
    }

}
