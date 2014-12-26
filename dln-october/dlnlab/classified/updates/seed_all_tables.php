<?php namespace DLNLab\Classified\Updates;

use October\Rain\Database\Updates\Seeder;
use DLNLab\Classified\Models\Ad;

class SeedAllTables extends Seeder
{

    public function run()
    {
        Ad::insert([
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => false, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => false, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => false, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => false, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
			['name' => 'Test Ad ' . rand(), 'slug' => 'test-slug-' . rand(), 'description' => 'Hello Worlds', 'status' => true, 'price' => rand(), 'user_id' => 1],
		]);
    }

}
