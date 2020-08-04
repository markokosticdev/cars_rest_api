<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Store a newly created car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified car from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        //
    }

    /**
     * Display a listing of cars.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of cars by brand.
     *
     * @param $brand
     * @return void
     */
    public function indexBrands($brand)
    {
        //
    }

    /**
     * Display the specified car.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Buy the specified car.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function buy(Request $request, Car $car)
    {
        //
    }

    /**
     * Trade the specified car for old one.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function trade(Request $request, Car $car)
    {
        //
    }

    /**
     * Evaluate a car before trade for getting the price.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function tradeEvaluate(Request $request, Car $car)
    {
        //
    }
}
