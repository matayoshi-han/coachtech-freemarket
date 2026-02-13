<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category_item = [
            ['item_id' => 1, 'category_id' => 1], // 腕時計: ファッション
            ['item_id' => 1, 'category_id' => 5], // 腕時計: メンズ
            ['item_id' => 1, 'category_id' => 12], // 腕時計: アクセサリー
            ['item_id' => 2, 'category_id' => 2], // HDD: 家電
            ['item_id' => 3, 'category_id' => 10], // 玉ねぎ: キッチン
            ['item_id' => 4, 'category_id' => 1], // 革靴: ファッション
            ['item_id' => 4, 'category_id' => 5], // 革靴: メンズ
            ['item_id' => 5, 'category_id' => 2], // ノートPC: 家電
            ['item_id' => 6, 'category_id' => 2], // マイク: 家電
            ['item_id' => 7, 'category_id' => 1], // ショルダーバッグ: ファッション
            ['item_id' => 7, 'category_id' => 4], // ショルダーバッグ: レディース
            ['item_id' => 8, 'category_id' => 10], // タンブラー: キッチン
            ['item_id' => 9, 'category_id' => 10], // コーヒーミル: キッチン
            ['item_id' => 10, 'category_id' => 4], // メイクセット: レディース
            ['item_id' => 10, 'category_id' => 6], // メイクセット: コスメ
        ];

        DB::table('category_item')->insert($category_item);
    }
}
