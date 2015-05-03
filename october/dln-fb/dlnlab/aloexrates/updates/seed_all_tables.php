<?php namespace DLNLab\AloExrates\Updates;

use October\Rain\Database\Updates\Seeder;
use DLNLab\AloExrates\Models\Currency;

class SeedAllTables extends Seeder
{

    public function run()
    {   
        $timestamp = \Carbon\Carbon::now()->toDateTimeString();

        Currency::insert([
            ['code' => 'AUD', 'name' => 'Úc', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'CAD', 'name' => 'Canada', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'CHF', 'name' => 'Pháp', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'DKK', 'name' => 'Đan mạch', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'EUR', 'name' => 'Euro', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'GBP', 'name' => 'Bảng Anh', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'HKD', 'name' => 'Hồng Kông', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'INR', 'name' => 'Ấn Độ', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'JPY', 'name' => 'Nhật', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'KRW', 'name' => 'Hàn Quốc', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'MYR', 'name' => 'Malaysia', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'RUB', 'name' => 'Nga', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'SAR', 'name' => 'Ả Rập Saudi', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'SEK', 'name' => 'Thụy Sĩ', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'SGD', 'name' => 'Singapore', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'THB', 'name' => 'Thái Lan', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
            ['code' => 'USD', 'name' => 'Mĩ', 'status' => 1, 'flag' => '', 'updated_at' => $timestamp, 'created_at' => $timestamp],
        ]);
    }

}
