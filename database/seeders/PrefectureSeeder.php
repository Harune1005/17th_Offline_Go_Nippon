<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrefectureSeeder extends Seeder
{
    public function run(): void
    {
        $prefectures = [
            ['code' => 1,  'name' => 'Hokkaido', 'latitude' => '43.06417', 'longitude' => '141.34694'],
            ['code' => 2,  'name' => 'Aomori', 'latitude' => '40.82444', 'longitude' => '140.74'],
            ['code' => 3,  'name' => 'Iwate', 'latitude' => '39.70361', 'longitude' => '141.1525'],
            ['code' => 4,  'name' => 'Miyagi', 'latitude' => '38.26889', 'longitude' => '140.87194'],
            ['code' => 5,  'name' => 'Akita', 'latitude' => '39.71861', 'longitude' => '140.1025'],
            ['code' => 6,  'name' => 'Yamagata', 'latitude' => '38.24056', 'longitude' => '140.36333'],
            ['code' => 7,  'name' => 'Fukushima', 'latitude' => '37.75', 'longitude' => '140.46778'],
            ['code' => 8,  'name' => 'Ibaraki', 'latitude' => '36.34139', 'longitude' => '140.44667'],
            ['code' => 9,  'name' => 'Tochigi', 'latitude' => '36.56583', 'longitude' => '139.88361'],
            ['code' => 10, 'name' => 'Gunma', 'latitude' => '36.39111', 'longitude' => '139.06083'],
            ['code' => 11, 'name' => 'Saitama', 'latitude' => '35.85694', 'longitude' => '139.64889'],
            ['code' => 12, 'name' => 'Chiba', 'latitude' => '35.60472', 'longitude' => '140.12333'],
            ['code' => 13, 'name' => 'Tokyo', 'latitude' => '35.68944', 'longitude' => '139.69167'],
            ['code' => 14, 'name' => 'Kanagawa', 'latitude' => '35.44778', 'longitude' => '139.6425'],
            ['code' => 15, 'name' => 'Niigata', 'latitude' => '37.90222', 'longitude' => '139.02361'],
            ['code' => 16, 'name' => 'Toyama', 'latitude' => '36.69528', 'longitude' => '137.21139'],
            ['code' => 17, 'name' => 'Ishikawa', 'latitude' => '36.59444', 'longitude' => '136.62556'],
            ['code' => 18, 'name' => 'Fukui', 'latitude' => '36.06528', 'longitude' => '136.22194'],
            ['code' => 19, 'name' => 'Yamanashi', 'latitude' => '35.66389', 'longitude' => '138.56833'],
            ['code' => 20, 'name' => 'Nagano', 'latitude' => '36.65139', 'longitude' => '138.18111'],
            ['code' => 21, 'name' => 'Gifu', 'latitude' => '35.39111', 'longitude' => '136.72222'],
            ['code' => 22, 'name' => 'Shizuoka', 'latitude' => '34.97694', 'longitude' => '138.38306'],
            ['code' => 23, 'name' => 'Aichi', 'latitude' => '35.18028', 'longitude' => '136.90667'],
            ['code' => 24, 'name' => 'Mie', 'latitude' => '34.73028', 'longitude' => '136.50861'],
            ['code' => 25, 'name' => 'Shiga', 'latitude' => '35.00444', 'longitude' => '135.86833'],
            ['code' => 26, 'name' => 'Kyoto', 'latitude' => '35.02139', 'longitude' => '135.75556'],
            ['code' => 27, 'name' => 'Osaka', 'latitude' => '34.68639', 'longitude' => '135.52'],
            ['code' => 28, 'name' => 'Hyogo', 'latitude' => '34.69139', 'longitude' => '135.18306'],
            ['code' => 29, 'name' => 'Nara', 'latitude' => '34.68528', 'longitude' => '135.83278'],
            ['code' => 30, 'name' => 'Wakayama', 'latitude' => '34.22611', 'longitude' => '135.1675'],
            ['code' => 31, 'name' => 'Tottori', 'latitude' => '35.50361', 'longitude' => '134.23833'],
            ['code' => 32, 'name' => 'Shimane', 'latitude' => '35.47222', 'longitude' => '133.05056'],
            ['code' => 33, 'name' => 'Okayama', 'latitude' => '34.66167', 'longitude' => '133.935'],
            ['code' => 34, 'name' => 'Hiroshima', 'latitude' => '34.39639', 'longitude' => '132.45944'],
            ['code' => 35, 'name' => 'Yamaguchi', 'latitude' => '34.18583', 'longitude' => '131.47139'],
            ['code' => 36, 'name' => 'Tokushima', 'latitude' => '34.06583', 'longitude' => '134.55944'],
            ['code' => 37, 'name' => 'Kagawa', 'latitude' => '34.34028', 'longitude' => '134.04333'],
            ['code' => 38, 'name' => 'Ehime', 'latitude' => '33.84167', 'longitude' => '132.76611'],
            ['code' => 39, 'name' => 'Kochi', 'latitude' => '33.55972', 'longitude' => '133.53111'],
            ['code' => 40, 'name' => 'Fukuoka', 'latitude' => '33.60639', 'longitude' => '130.41806'],
            ['code' => 41, 'name' => 'Saga', 'latitude' => '33.24944', 'longitude' => '130.29889'],
            ['code' => 42, 'name' => 'Nagasaki', 'latitude' => '32.74472', 'longitude' => '129.87361'],
            ['code' => 43, 'name' => 'Kumamoto', 'latitude' => '32.78972', 'longitude' => '130.74167'],
            ['code' => 44, 'name' => 'Oita', 'latitude' => '33.23806', 'longitude' => '131.6125'],
            ['code' => 45, 'name' => 'Miyazaki', 'latitude' => '31.91111', 'longitude' => '131.42389'],
            ['code' => 46, 'name' => 'Kagoshima', 'latitude' => '31.56028', 'longitude' => '130.55806'],
            ['code' => 47, 'name' => 'Okinawa', 'latitude' => '26.2125', 'longitude' => '127.68111'],
        ];

        DB::table('prefectures')->insert($prefectures);
    }
}
