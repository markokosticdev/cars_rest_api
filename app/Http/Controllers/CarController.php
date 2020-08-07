<?php

namespace App\Http\Controllers;

use App\Car;
use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * Store a newly created car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        Validator::make($data, [
            'brand' => 'required|filled',
            'class' => 'required|filled',
            'model' => 'required|filled',
            'price' => 'required|filled|numeric',
        ])->validate();

        Car::create([
            'brand' => $data['brand'],
            'class' => $data['class'],
            'model' => $data['model'],
            'price' => $data['price'],
        ]);

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Update the specified car in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Car  $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Car $car)
    {
        $data = json_decode($request->getContent(), true);

        Validator::make($data, [
            'brand' => 'required|filled',
            'class' => 'required|filled',
            'model' => 'required|filled',
            'price' => 'required|filled|numeric',
        ])->validate();

        $car->update([
            'brand' => $data['brand'],
            'class' => $data['class'],
            'model' => $data['model'],
            'price' => $data['price'],
        ]);

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Remove the specified car from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Car $car)
    {
        $car->delete();

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Display a listing of cars.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $per_page = !($request->input('per_page')) ? 10 : $request->input('per_page');
        $data = Car::paginate($per_page);

        return response()->json($data);
    }

    /**
     * Display a listing of cars by brand.
     *
     * @param $brand
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexBrands(Request $request, $brand)
    {
        $per_page = !($request->input('per_page')) ? 10 : $request->input('per_page');
        $data = Car::where('brand', $brand)->paginate($per_page);

        return response()->json($data);
    }

    /**
     * Display the specified car.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Car $car)
    {
        $data = $car;

        return response()->json($data);
    }

    /**
     * Buy the specified car.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function buy(Request $request, Car $car)
    {
        $data = json_decode($request->getContent(), true);

        Validator::make($data, [
            'client_id' => 'required|filled|exists:clients,id',
        ])->validate();

        History::create([
            'client_id' => $data['client_id'],
            'car_id' => $car->id,
            'type' => 'buy',
            'payed' => $car->price,
        ]);

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Trade the specified car for old one.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function trade(Request $request, Car $car)
    {
        $data = json_decode($request->getContent(), true);

        Validator::make($data, [
            'client_id' => 'required|filled|exists:clients,id',
            'old_car.brand' => 'required|filled',
            'old_car.class' => 'required|filled',
            'old_car.model' => 'required|filled',
            'old_car.year' => 'required|filled|numeric'
        ])->validate();

        History::create([
            'client_id' => $data['client_id'],
            'car_id' => $car->id,
            'type' => 'trade',
            'payed' => $car->price - self::evaluate($data['old_car']),
        ]);

        return response()->json(['success' => 'success'], 200);
    }

    /**
     * Evaluate a car before trade for getting the price.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\JsonResponse
     */
    public function tradeEvaluate(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        Validator::make($data, [
            'old_car.brand' => 'required|filled',
            'old_car.class' => 'required|filled',
            'old_car.model' => 'required|filled',
            'old_car.year' => 'required|filled|numeric'
        ])->validate();

        return response()->json(['value' => self::evaluate($data['old_car'])]);
    }

    private function evaluate($old_car){
        $diff_year = date("Y") - $old_car['year'];
        if($diff_year >= 0 && $diff_year <= 10){
            return $diff_year * 100;
        }elseif ($diff_year > 10){
            return 100;
        }else{
            return 0;
        }
    }
}
