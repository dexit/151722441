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
            ['code' => 'Hồ Chí Minh|Vàng SJC 1L', 'type' => 'GOLD', 'name' => 'SJC Hồ Chí Minh', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Hà Nội|Vàng SJC', 'type' => 'GOLD', 'name' => 'SJC Hà Nội', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Đà Nẵng|Vàng SJC', 'type' => 'GOLD', 'name' => 'SJC Đà Nẵng', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Nha Trang|Vàng SJC', 'type' => 'GOLD', 'name' => 'SJC Nha Trang', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Cà Mau|Vàng SJC', 'type' => 'GOLD', 'name' => 'SJC Cà Mau', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Buôn Ma Thuột|Vàng SJC', 'type' => 'GOLD', 'name' => 'SJC Buôn Ma Thuột', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Bình Phước|Vàng SJC', 'type' => 'GOLD', 'name' => 'SJC Bình Phước', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Huế|Vàng SJC', 'type' => 'GOLD', 'name' => 'SJC Huế', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Hồ Chí Minh|Vàng nhẫn SJC 99,99 5p,1c,2c,5c', 'type' => 'GOLD', 'name' => 'Vàng nhẫn SJC 99,99 5p,1c,2c,5c', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Hồ Chí Minh|Vàng nữ trang 99,99%', 'type' => 'GOLD', 'name' => 'Vàng nữ trang 99,99%', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Hồ Chí Minh|Vàng nữ trang 99%', 'type' => 'GOLD', 'name' => 'Vàng nữ trang 99%', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'Hồ Chí Minh|Vàng nữ trang 75%', 'type' => 'GOLD', 'name' => 'Vàng nữ trang 75%', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'AUD', 'name' => 'VCB Úc', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'CAD', 'name' => 'VCB Canada', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'CHF', 'name' => 'VCB Pháp', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'DKK', 'name' => 'VCB Đan mạch', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'EUR', 'name' => 'VCB Euro', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'GBP', 'name' => 'VCB Bảng Anh', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'HKD', 'name' => 'VCB Hồng Kông', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'INR', 'name' => 'VCB Ấn Độ', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'JPY', 'name' => 'VCB Nhật', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'KRW', 'name' => 'VCB Hàn Quốc', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'MYR', 'name' => 'VCB Malaysia', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'RUB', 'name' => 'VCB Nga', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'SAR', 'name' => 'VCB Ả Rập Saudi', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'SEK', 'name' => 'VCB Thụy Sĩ', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'SGD', 'name' => 'VCB Singapore', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'THB', 'name' => 'VCB Thái Lan', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'USD', 'name' => 'VCB Mĩ', 'type' => 'VCB', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ]);
    }

}
