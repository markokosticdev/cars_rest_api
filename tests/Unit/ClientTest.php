<?php

namespace Tests\Unit;

use App\Car;
use App\Client;
use App\History;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class ClientTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test displaying a listing of clients.
     */
    public function testIndex()
    {
        factory(Client::class, 200)->create();

        $url = URL::signedRoute('clients');

        $this->getJson($url)
            ->assertSuccessful()
            ->assertJsonStructure(['total', 'per_page', 'current_page', 'last_page', 'first_page_url', 'last_page_url', 'next_page_url', 'prev_page_url', 'path', 'from', 'to', 'data']);

        $url = URL::signedRoute('clients', ['per_page' => rand(1,200)]);

        $this->getJson($url)
            ->assertSuccessful()
            ->assertJsonStructure(['total', 'per_page', 'current_page', 'last_page', 'first_page_url', 'last_page_url', 'next_page_url', 'prev_page_url', 'path', 'from', 'to', 'data']);
    }

    /**
     * Test storing a newly created client in storage.
     */
    public function testStore()
    {
        $url = URL::signedRoute('clients.add');

        $data = factory(Client::class)->make()->toArray();

        $this->postJson($url, $data)
            ->assertSuccessful()
            ->assertJsonFragment(['success' => 'success']);
    }

    /**
     * Test displaying the specified client.
     */
    public function testShow()
    {
        factory(Client::class, 200)->create();

        $url = URL::signedRoute('clients.show', ['client' => rand(0,200)]);

        $this->getJson($url)
            ->assertSuccessful()
            ->assertJsonStructure(['username', 'firstname', 'lastname', 'email']);
    }

    /**
     * Test updating the specified client in storage.
     */
    public function testUpdate()
    {
        factory(Client::class, 200)->create();

        $url = URL::signedRoute('clients.update', ['client' => rand(0,200)]);

        $data = factory(Client::class)->make()->toArray();

        $this->patchJson($url, $data)->dump()
            ->assertSuccessful()
            ->assertJsonFragment(['success' => 'success']);
    }

    /**
     * Test removing the specified client from storage.
     */
    public function testDestroy()
    {
        factory(Client::class, 200)->create();

        $url = URL::signedRoute('clients.remove', ['client' => rand(0,200)]);

        $this->deleteJson($url)
            ->assertSuccessful()
            ->assertJsonFragment(['success' => 'success']);
    }

    /**
     * Test displaying the specified client history.
     */
    public function testShowHistory()
    {
        factory(Client::class, 200)->create();
        factory(Car::class, 100)->create();
        factory(History::class, 400)->create();

        $url = URL::signedRoute('clients.history.show', ['client' => rand(0,200)]);

        $this->getJson($url)
            ->assertSuccessful()
            ->assertJsonStructure([['client_id', 'car_id']]);
    }

    /**
     * Test removeing the specified client history from storage.
     */
    public function testDestroyHistory()
    {
        factory(Client::class, 200)->create();
        factory(Car::class, 100)->create();
        factory(History::class, 400)->create();

        $url = URL::signedRoute('clients.history.remove', ['client' => rand(0,200)]);

        $this->deleteJson($url)
            ->assertSuccessful()
            ->assertJsonFragment(['success' => 'success']);
    }
}
