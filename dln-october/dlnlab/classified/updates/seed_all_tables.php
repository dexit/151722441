<?php namespace DLNLab\Classified\Updates;

use October\Rain\Database\Updates\Seeder;
use DLNLab\Classified\Models\Ad;
use DLNLab\Classified\Models\Tag;

class SeedAllTables extends Seeder
{

    public function run()
    {   
        $timestamp = \Carbon\Carbon::now()->toDateTimeString();
        Tag::insert([
            ['name' => 'Bán', 'slug' => 'ban', 'type' => 'ad_kind', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Cho thuê', 'slug' => 'cho-thue', 'type' => 'ad_kind', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Ban công', 'slug' => 'ban-cong', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Bảo vệ', 'slug' => 'bao-ve', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Bể bơi', 'slug' => 'be-boi', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Bình nóng lạnh', 'slug' => 'binh-nong-lanh', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Chỗ để xe', 'slug' => 'cho-de-xe', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1,  'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Điều hòa nhiệt độ', 'slug' => 'dieu-hoa-nhiet-do', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Gara ô tô', 'slug' => 'gara-o-to', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Internet', 'slug' => 'internet', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Máy giặt', 'slug' => 'may-giat', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Tivi', 'slug' => 'ti-vi', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Truyền hình cáp', 'slug' => 'truyen-hinh-cap', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Tủ lạnh', 'slug' => 'tu-lanh', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Thang máy', 'slug' => 'thang-may', 'type' => 'ad_amenities', 'icon' => '', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ]);
    }

}
