<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @return void
     */
    public function test_user_login(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password')
        ]);

        $response = $this->postJson(route('login', [
            'email' => 'user@example.com',
            'password' => 'password'
        ]));

        $this->assertAuthenticatedAs($user);

        $response->assertStatus(200)->assertJsonStructure([
            'user' => ['id', 'email', 'access_token']
        ]);
    }
}
