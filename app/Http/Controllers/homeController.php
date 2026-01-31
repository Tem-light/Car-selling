<?php

namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Maker;
use App\Models\User;
use App\Models\Model;
use App\Models\CarImages;
use App\Models\City;
use App\Models\CarType;
use App\Models\FuelType;
use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
        //render home page
        $cars=Car::where('published_at','<',now())->with(['primaryImage','city','carType','fuelType','maker','carModel'])->orderBy('published_at','desc')->limit(20)->get();

        return view('index',[
            'cars'=>$cars,
        ]);

    }
}
