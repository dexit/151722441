<?php namespace DLNLab\FBNews\Updates;

use October\Rain\Database\Updates\Seeder;
use DLNLab\FBNews\Models\FbCategory;

class SeedAllTables extends Seeder
{

    public function run()
    {   
        $timestamp = \Carbon\Carbon::now()->toDateTimeString();
        
        FbCategory::insert([
            ['name' => 'Hài vui', 'slug' => 'hai-vui', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Hot girl', 'slug' => 'hot-girl', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Tin tức', 'slug' => 'tin-tuc', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Bóng đá', 'slug' => 'bong-da', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ]);
    }

}
