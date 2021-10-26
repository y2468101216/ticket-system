<?php

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TicketTest extends TestCase
{
    use DatabaseTransactions;

    public function testListTicket()
    {
        $response = $this->get('/api/ticket');

        $response->assertStatus(200);
    }

    public function testCreateTicket()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['ticket:create']
        );

        $response = $this->post('/api/ticket/create', [
            "name" => "test",
            "type" => 0
        ]);

        $response->assertStatus(200);
    }

    public function testUpdateTicket()
    {
        $ticket = Ticket::create([
            'type' => 0,
            'name' => 'test',
            'status' => 0
        ]);

        Sanctum::actingAs(
            User::factory()->create(),
            ['ticket:update']
        );

        $response = $this->put('/api/ticket/update/'.$ticket->id, [
            "name" => "test",
            "type" => 0
        ]);

        $response->assertStatus(200);
    }

    public function testResolveTicket()
    {
        $ticket = Ticket::create([
            'type' => 0,
            'name' => 'test',
            'status' => 0
        ]);

        Sanctum::actingAs(
            User::factory()->create(),
            ['ticket:resolve']
        );

        $response = $this->put('/api/ticket/resolve/'.$ticket->id);

        $response->assertStatus(200);
    }

    public function testDeleteTicket()
    {
        $ticket = Ticket::create([
            'type' => 0,
            'name' => 'test',
            'status' => 0
        ]);

        Sanctum::actingAs(
            User::factory()->create(),
            ['ticket:delete']
        );

        $response = $this->delete('/api/ticket/delete/'.$ticket->id);

        $response->assertStatus(200);
    }
}
