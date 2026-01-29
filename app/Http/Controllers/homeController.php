<?php

namespace App\Http\Controllers;
use App\Models\Car;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        // $car = new Car();

        // $car->maker_id      = 1;
        // $car->model_id      = 1;
        // $car->year          = 2020;
        // $car->price         = 30000;
        // $car->vin           = "1HGCM82633A123456";
        // $car->mileage       = 15000;
        // $car->user_id       = 1;
        // $car->city_id       = 1;
        // $car->car_type_id   = 1;
        // $car->fuel_type_id  = 1;
        // $car->address       = "123 Main St, Anytown, USA";
        // $car->phone         = "555-123-4567";
        // $car->description   = "A well-maintained car in excellent condition.";
        // $car->published_at  = now(); // Laravel helper function
        // // created_at and updated_at are automatically handled if your model uses timestamps

        // $carData=[
        //     'maker_id'      => 1,
        //     'model_id'      => 1,
        //     'year'          => 2020,
        //     'price'         => 30000,
        //     'vin'           => "1HGCM82633A123456",
        //     'mileage'       => 15000,
        //     'user_id'       => 1,
        //     'city_id'       => 1,
        //     'car_type_id'   => 1,
        //     'fuel_type_id'  => 1,
        //     'address'       => "123 Main St, Anytown, USA",
        //     'phone'         => "555-123-4567",
        //     'description'   => "A well-maintained car in excellent condition.",
        //     'published_at'  => now(),
        // ];

        // $car = new Car($carData);

        // $car->save();
                return view('index');

    }
}
