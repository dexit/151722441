<?php namespace DLNLab\Classified\Updates;

use October\Rain\Database\Updates\Seeder;
use DLNLab\Classified\Models\AdCategory;
use DLNLab\Classified\Models\Tag;

class SeedAllTables extends Seeder
{

    public function run()
    {   
        $timestamp = \Carbon\Carbon::now()->toDateTimeString();
        
        AdCategory::insert([
            ['name' => 'Căn hộ chung cư', 'slug' => 'can-ho-chung-cu', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Nhà trọ, phòng trọ', 'slug' => 'nha-tro', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Nhà riêng', 'slug' => 'nha-rieng', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Nhà mặt phố', 'slug' => 'nha-mat-pho', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Đất', 'slug' => 'dat', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Văn phòng', 'slug' => 'van-phong', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Cửa hàng', 'slug' => 'cua-hang', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Nhà kho, xưởng', 'slug' => 'nha-kho', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['name' => 'Nhà đất khác', 'slug' => 'nha-dat-khac', 'status' => 1, 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ]);
        
        Tag::insert([
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
