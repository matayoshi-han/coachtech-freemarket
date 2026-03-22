<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Category;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品を出品できる()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($user)->post('/sell', [
            'item_name' => '出品テスト商品',
            'brand_name' => 'テストブランド',
            'item_description' => 'テストの説明文',
            'item_amount' => 5000,
            'condition' => '良好',
            'categories' => [$category->id],
            // ↓ image() ではなく create() に変更（GDライブラリが不要になります）
            'image' => \Illuminate\Http\Testing\File::create('test.jpg', 100)
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('items', ['item_name' => '出品テスト商品']);
    }

    /** @test */
    public function 購入画面での配送先変更がユーザー情報に反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/purchase/address/{$item->id}", [
            'postal_code' => '777-7777',
            'address' => '変更後の住所',
            'building' => '変更後の建物',
        ]);

        $response->assertRedirect("/purchase/{$item->id}");
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'address' => '変更後の住所'
        ]);
    }

    /** @test */
    public function 商品を購入できる()
    {
        $user = User::factory()->create(['address' => '東京都中央区']);
        $item = Item::factory()->create(['item_amount' => 3000]);

        // 注意：Stripe決済を含むため、テストではコンビニ払いを選択して決済処理を回避します
        $response = $this->actingAs($user)->post("/purchase/{$item->id}", [
            'payment_method' => 'convenience_store',
            'shipping_postal_code' => $user->postal_code,
            'shipping_address' => $user->address,
            'shipping_building' => $user->building,
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('orders', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'price' => 3000
        ]);
    }
}
