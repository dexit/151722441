<?php namespace DLNLab\Features\Updates;

use October\Rain\Database\Updates\Seeder;
use DLNLab\Features\Models\Notification;
use DLNLab\Features\Models\Report;

class SeedAllTables extends Seeder
{

    public function run()
    {
		Report::insert([
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
			['user_id' => 4, 'content' => 'Test Report ' . rand(), 'item_id' => '1', 'status' => 0, 'type' => 'ad' ],
		]);
    }

}
