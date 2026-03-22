<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全商品を取得できる()
    {
        Item::factory()->create(['item_name' => 'テスト商品A']);
        Item::factory()->create(['item_name' => 'テスト商品B']);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('テスト商品A');
        $response->assertSee('テスト商品B');
    }

    /** @test */
    public function 商品名で検索ができる()
    {
        Item::factory()->create(['item_name' => 'りんご']);
        Item::factory()->create(['item_name' => 'ばなな']);

        $response = $this->get('/?keyword=りんご');

        $response->assertSee('りんご');
        $response->assertDontSee('ばなな');
    }

    /** @test */
    public function 商品詳細情報を取得できる()
    {
        $item = Item::factory()->create([
            'item_name' => '詳細テスト商品',
            'item_description' => 'これはテストの説明文です'
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);
        $response->assertSee('詳細テスト商品');
        $response->assertSee('これはテストの説明文です');
    }

    /** @test */
    public function マイリスト一覧を取得できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create(['item_name' => 'お気に入り商品']);

        // いいねを登録
        $user->likes()->create(['item_id' => $item->id]);

        $response = $this->actingAs($user)->get('/?tag=mylist');

        $response->assertStatus(200);
        $response->assertSee('お気に入り商品');
    }
}
