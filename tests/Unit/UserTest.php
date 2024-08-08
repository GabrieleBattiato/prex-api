<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    protected function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        return $user;
    }

    public function test_store_user_new_favorite_gif_successfully(): void
    {
        $user = $this->authenticate();

        $gifData = [
            'user_id' => $user->id,
            'gif_id' => 'l3V0ADaHw4aAbfwOI',
            'alias' => 'Favorite gif'
        ];

        $response = $this->postJson(route('gif.store.favorite'), $gifData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('gif_users', $gifData);
    }
}
