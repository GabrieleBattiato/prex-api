<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\Passport\Passport;
use Tests\TestCase;

class GifTest extends TestCase
{
    use DatabaseTransactions;

    protected function authenticate()
    {
        $user = User::factory()->create();
        Passport::actingAs($user);
        return $user;
    }

    public function test_search_gif(): void
    {
        $this->authenticate();

        $response = $this->getJson(route('gif.search', ['text' => 'Funny Cat', 'limit' => 1, 'offset' => 0]));

        $response->assertStatus(200);
    }

    public function test_show_gif(): void
    {
        $this->authenticate();

        $response = $this->getJson(route('gif.show', ['id' => 'l3V0ADaHw4aAbfwOI']));

        $response->assertStatus(200);
    }

}