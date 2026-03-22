<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase; // テストごとにDBをリセットする

    /** @test */
    public function ログイン画面が表示される()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /** @test */
    public function 正しい情報でログインができる()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertAuthenticatedAs($user); // ログイン状態になったか確認
        $response->assertRedirect('/'); // トップページへリダイレクトされるか確認
    }

    /** @test */
    public function ログアウトができる()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest(); // ログアウト状態になったか確認
        $response->assertRedirect('/login');
    }
}
