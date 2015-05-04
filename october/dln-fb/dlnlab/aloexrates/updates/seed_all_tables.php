<?php namespace DLNLab\AloExrates\Updates;

use October\Rain\Database\Updates\Seeder;
use DLNLab\AloExrates\Models\Currency;

class SeedAllTables extends Seeder
{

    public function run()
    {   
        $timestamp = \Carbon\Carbon::now()->toDateTimeString();

        Currency::insert([
            ['code' => 'AUD', 'name' => 'Úc', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'CAD', 'name' => 'Canada', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'CHF', 'name' => 'Pháp', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'DKK', 'name' => 'Đan mạch', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'EUR', 'name' => 'Euro', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'GBP', 'name' => 'Bảng Anh', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'HKD', 'name' => 'Hồng Kông', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'INR', 'name' => 'Ấn Độ', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'JPY', 'name' => 'Nhật', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'KRW', 'name' => 'Hàn Quốc', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'MYR', 'name' => 'Malaysia', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'RUB', 'name' => 'Nga', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'SAR', 'name' => 'Ả Rập Saudi', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'SEK', 'name' => 'Thụy Sĩ', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'SGD', 'name' => 'Singapore', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'THB', 'name' => 'Thái Lan', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'USD', 'name' => 'Mĩ', 'type' => 'CURRENCY', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Hồ Chí Minh', 'type' => 'GOLD', 'name' => 'SJC Hồ Chí Minh', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Hà Nội', 'type' => 'GOLD', 'name' => 'SJC Hà Nội', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Đà Nẵng', 'type' => 'GOLD', 'name' => 'SJC Đà Nẵng', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Nha Trang', 'type' => 'GOLD', 'name' => 'SJC Nha Trang', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Cà Mau', 'type' => 'GOLD', 'name' => 'SJC Cà Mau', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Buôn Ma Thuột', 'type' => 'GOLD', 'name' => 'SJC Buôn Ma Thuột', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Bình Phước', 'type' => 'GOLD', 'name' => 'SJC Bình Phước', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Huế', 'type' => 'GOLD', 'name' => 'SJC Huế', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ]);
    }

}
