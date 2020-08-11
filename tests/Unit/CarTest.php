<?php

namespace Tests\Unit;

use App\Car;
use App\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class CarTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test storing a newly created car in storage.
     */
    public function testStore()
    {
        $url = URL::signedRoute('cars.add');

        $data = factory(Car::class)->make()->toArray();

        $this->postJson($url, $data)
            ->assertSuccessful()
            ->assertJsonFragment(['success' => 'success']);
    }

    /**
     * Test updating the specified car in storage.
     */
    public function testUpdate()
    {
        factory(Car::class, 100)->create();

        $url = URL::signedRoute('cars.update', ['car' => rand(0,100)]);

        $data = factory(Car::class)->make()->toArray();

        $this->patchJson($url, $data)
            ->assertSuccessful()
            ->assertJsonFragment(['success' => 'success']);
    }

    /**
     * Test removing the specified car from storage.
     */
    public function testDestroy()
    {
        factory(Car::class, 100)->create();

        $url = URL::signedRoute('cars.remove', ['car' => rand(0,100)]);

        $this->deleteJson($url)
            ->assertSuccessful()
            ->assertJsonFragment(['success' => 'success']);
    }

    /**
     * Test displaying a listing of cars.
     */
    public function testIndex()
    {
        factory(Car::class, 100)->create();

        $url = URL::signedRoute('cars');

        $this->getJson($url)
            ->assertSuccessful()
            ->assertJsonStructure(['total', 'per_page', 'current_page', 'last_page', 'first_page_url', 'last_page_url', 'next_page_url', 'prev_page_url', 'path', 'from', 'to', 'data']);

        $url = URL::signedRoute('cars', ['per_page' => rand(1,100)]);

        $this->getJson($url)
            ->assertSuccessful()
            ->assertJsonStructure(['total', 'per_page', 'current_page', 'last_page', 'first_page_url', 'last_page_url', 'next_page_url', 'prev_page_url', 'path', 'from', 'to', 'data']);
    }

    /**
     * Test displaying a listing of cars by brand.
     */
    public function testIndexBrands()
    {
        factory(Car::class, 100)->create();

        $brands = json_decode(File::get(base_path() . '/database/data/cars_brands.json'));

        $url = URL::signedRoute('cars.brands', ['brand' => Arr::random($brands)]);

        $this->getJson($url)
            ->assertSuccessful()
            ->assertJsonStructure(['total', 'per_page', 'current_page', 'last_page', 'first_page_url', 'last_page_url', 'next_page_url', 'prev_page_url', 'path', 'from', 'to', 'data']);
    }

    /**
     * Test displaying the specified car.
     */
    public function testShow()
    {
        factory(Car::class, 100)->create();

        $url = URL::signedRoute('cars.show', ['car' => rand(0,100)]);

        $this->getJson($url)
            ->assertSuccessful()
            ->assertJsonStructure(['brand', 'class', 'model', 'price']);
    }

    /**
     * Test buying the specified car.
     */
    public function testBuy()
    {
        factory(Client::class, 200)->create();
        factory(Car::class, 100)->create();

        $url = URL::signedRoute('cars.buy', ['car' => rand(0,100)]);

        $data = [
            'client_id' => Client::all()->random()->id
        ];

        $this->postJson($url, $data)
            ->assertSuccessful()
            ->assertJsonFragment(['success' => 'success']);
    }

    /**
     * Test trading the specified car for old one.
     */
    public function testTrade()
    {
        factory(Client::class, 200)->create();
        factory(Car::class, 100)->create();

        $url = URL::signedRoute('cars.trade', ['car' => rand(0,100)]);

        $data = [
            'client_id' => Client::all()->random()->id,
            'old_car' => [
                'brand' => 'Tesla',
                'class' => 'Model S',
                'model' => 'E',
                'year' => 2015
            ]
        ];

        $this->postJson($url, $data)
            ->assertSuccessful()
            ->assertJsonFragment(['success' => 'success']);
    }

    /**
     * Test evaluating a car before trade for getting the price.
     */
    public function testTradeEvaluate()
    {
        $url = URL::signedRoute('cars.trade.evaluate');

        $data = [
            'old_car' => [
                'brand' => 'Tesla',
                'class' => 'Model S',
                'model' => 'E',
                'year' => 2015
            ]
        ];

        $this->postJson($url, $data)
            ->assertSuccessful()
            ->assertJsonStructure(['value']);
    }
}
