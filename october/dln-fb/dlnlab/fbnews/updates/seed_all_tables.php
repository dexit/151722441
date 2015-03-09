<?php namespace DLNLab\FBNews\Updates;

use October\Rain\Database\Updates\Seeder;
use DLNLab\FBNews\Models\FbCategory;
use DLNLab\FBNews\Models\FbPage;

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
        
        FbPage::insert([
            ['fb_id' => '755038977864672', 'category_id' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['fb_id' => '487998621317746', 'category_id' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['fb_id' => '232665283585847', 'category_id' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['fb_id' => '506318469450579', 'category_id' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ]);
    }

}
