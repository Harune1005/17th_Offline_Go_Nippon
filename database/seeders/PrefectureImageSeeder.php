<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrefectureImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $images = [
            1 => 'images/prefectures/hokkaido.jpeg',
            2 => 'images/prefectures/aomori.jpeg',
            3 => 'images/prefectures/iwate.jpeg',
            4 => 'images/prefectures/miyagi.jpeg',
            5 => 'images/prefectures/akita.jpeg',
            6 => 'images/prefectures/yamagata.jpeg',
            7 => 'images/prefectures/fukushima.jpeg',
            8 => 'images/prefectures/ibaraki.jpeg',
            9 => 'images/prefectures/tochigi.jpeg',
            10 => 'images/prefectures/gunma.jpeg',
            11 => 'images/prefectures/saitama.jpeg',
            12 => 'images/prefectures/chiba.jpeg',
            13 => 'images/prefectures/tokyo.jpeg',
            14 => 'images/prefectures/kanagawa.jpeg',
            15 => 'images/prefectures/niigata.jpeg',
            16 => 'images/prefectures/toyama.jpeg',
            17 => 'images/prefectures/ishikawa.jpeg',
            18 => 'images/prefectures/fukui.jpeg',
            19 => 'images/prefectures/yamanashi.jpeg',
            20 => 'images/prefectures/nagano.jpeg',
            21 => 'images/prefectures/gifu.jpeg',
            22 => 'images/prefectures/shizuoka.jpeg',
            23 => 'images/prefectures/aichi.jpeg',
            24 => 'images/prefectures/mie.jpeg',
            25 => 'images/prefectures/shiga.jpeg',
            26 => 'images/prefectures/kyoto.jpeg',
            27 => 'images/prefectures/osaka.jpeg',
            28 => 'images/prefectures/hyogo.jpeg',
            29 => 'images/prefectures/nara.jpeg',
            30 => 'images/prefectures/wakayama.jpeg',
            31 => 'images/prefectures/tottori.jpeg',
            32 => 'images/prefectures/shimane.jpeg',
            33 => 'images/prefectures/okayama.jpeg',
            34 => 'images/prefectures/hiroshima.jpeg',
            35 => 'images/prefectures/yamaguchi.jpeg',
            36 => 'images/prefectures/tokushima.jpeg',
            37 => 'images/prefectures/kagawa.jpeg',
            38 => 'images/prefectures/ehime.jpeg',
            39 => 'images/prefectures/kochi.jpeg',
            40 => 'images/prefectures/fukuoka.jpeg',
            41 => 'images/prefectures/saga.jpeg',
            42 => 'images/prefectures/nagasaki.jpeg',
            43 => 'images/prefectures/kumamoto.jpeg',
            44 => 'images/prefectures/oita.jpeg',
            45 => 'images/prefectures/miyazaki.jpeg',
            46 => 'images/prefectures/kagoshima.jpeg',
            47 => 'images/prefectures/okinawa.jpeg',
        ];

        foreach ($images as $code => $path) {
            DB::table('prefectures')
                ->where('code', $code)
                ->update(['image' => $path]);
        }
    }
}
