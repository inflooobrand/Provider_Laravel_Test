<?php


namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_all_orders()
    {
        
        $this->withoutMiddleware(); 

        Order::factory()->count(5)->create();

        $response = $this->get('/api/orders');

        $response->assertStatus(200);
                 ->assertJsonCount(5);
    }

}
