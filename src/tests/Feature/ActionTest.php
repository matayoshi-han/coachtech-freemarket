<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class ActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいね機能が正しく動作する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 1回目：いいね登録
        $this->actingAs($user)->post("/like/{$item->id}");
        $this->assertDatabaseHas('likes', ['user_id' => $user->id, 'item_id' => $item->id]);

        // 2回目：いいね解除（トグル機能）
        $this->actingAs($user)->post("/like/{$item->id}");
        $this->assertDatabaseMissing('likes', ['user_id' => $user->id, 'item_id' => $item->id]);
    }

    /** @test */
    public function コメントを投稿できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post("/comment/{$item->id}", [
            'comment_text' => 'テストコメントです'
        ]);

        $response->assertStatus(302); // リダイレクト（back）の確認
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment_text' => 'テストコメントです'
        ]);
    }

    /** @test */
    public function ユーザー情報が変更できる()
    {
        $user = User::factory()->create(['name' => '元の名前']);

        $response = $this->actingAs($user)->post('/mypage/profile', [
            'name' => '新しい名前',
            'postal_code' => '999-9999',
            'address' => '新しい住所',
            'building' => '新しい建物',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => '新しい名前',
            'address' => '新しい住所'
        ]);
    }
}
