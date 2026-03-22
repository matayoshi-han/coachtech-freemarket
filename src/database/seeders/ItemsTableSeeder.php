<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    public function run()
    {
        $items = [
            [
                'id' => 1,
                'user_id' => 2,
                'image_url' => 'storage/Armani+Mens+Clock.jpg',
                'item_state' => '良好',
                'item_name' => '腕時計',
                'item_brand' => 'Rolex',
                'item_description' => 'スタイリッシュなデザインのメンズ腕時計',
                'item_amount' => 15000,
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'image_url' => 'storage/HDD+Hard+Disk.jpg',
                'item_state' => '目立った傷や汚れなし',
                'item_name' => 'HDD',
                'item_brand' => '西芝',
                'item_description' => '高速で信頼背の高いハードディスク',
                'item_amount' => 5000,
            ],
            [
                'id' => 3,
                'user_id' => 4,
                'image_url' => 'storage/iLoveIMG+d.jpg',
                'item_state' => 'やや傷や汚れあり',
                'item_name' => '玉ねぎ３束',
                'item_brand' => 'なし',
                'item_description' => '新鮮な玉ねぎの３束セット',
                'item_amount' => 300,
            ],
            [
                'id' => 4,
                'user_id' => 2,
                'image_url' => 'storage/Leather+Shoes+Product+Photo.jpg',
                'item_state' => '状態が悪い',
                'item_name' => '革靴',
                'item_brand' => null,
                'item_description' => 'クラシックなデザインの革靴',
                'item_amount' => 4000,
            ],
            [
                'id' => 5,
                'user_id' => 3,
                'image_url' => 'storage/Living+Room+Laptop.jpg',
                'item_state' => '良好',
                'item_name' => 'ノートPC',
                'item_brand' => null,
                'item_description' => '高性能なノートパソコン',
                'item_amount' => 45000,
            ],
            [
                'id' => 6,
                'user_id' => 4,
                'image_url' => 'storage/Music+Mic+4632231.jpg',
                'item_state' => '目立った傷や汚れなし',
                'item_name' => 'マイク',
                'item_brand' => 'なし',
                'item_description' => '高音質のレコーディングマイク',
                'item_amount' => 8000,
            ],
            [
                'id' => 7,
                'user_id' => 2,
                'image_url' => 'storage/Purse+fashion+pocket.jpg',
                'item_state' => 'やや傷や汚れあり',
                'item_name' => 'ショルダーバッグ',
                'item_brand' => null,
                'item_description' => 'おしゃれなショルダーバッグ',
                'item_amount' => 3500,
            ],
            [
                'id' => 8,
                'user_id' => 3,
                'image_url' => 'storage/Tumbler+souvenir.jpg',
                'item_state' => '状態が悪い',
                'item_name' => 'タンブラー',
                'item_brand' => 'なし',
                'item_description' => '使いやすいタンブラー',
                'item_amount' => 500,
            ],
            [
                'id' => 9,
                'user_id' => 4,
                'image_url' => 'storage/Waitress+with+Coffee+Grinder.jpg',
                'item_state' => '良好',
                'item_name' => 'コーヒーミル',
                'item_brand' => 'Starbucks',
                'item_description' => '手動のコーヒーミル',
                'item_amount' => 4000,
            ],
            [
                'id' => 10,
                'user_id' => 2,
                'image_url' => 'storage/外出メイクアップセット.jpg',
                'item_state' => '目立った傷や汚れなし',
                'item_name' => 'メイクセット',
                'item_brand' => null,
                'item_description' => '便利なメイクアップセット',
                'item_amount' => 2500,
            ],
        ];

        foreach ($items as $item) {
            $item['created_at'] = now();
            $item['updated_at'] = now();
            DB::table('items')->insert($item);
        }
    }
}
