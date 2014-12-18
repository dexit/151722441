<?php namespace DLNLab\Features\Updates;

use October\Rain\Database\Updates\Seeder;
use DLNLab\Features\Models\Notification;

class SeedAllTables extends Seeder
{

    public function run()
    {
        Notification::insert([
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
			['user_id' => 4, 'type' => 'referer_complete', 'content' => 'Hello Worlds', 'read' => 0],
		]);
    }

}
