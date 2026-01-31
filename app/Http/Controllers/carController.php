<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\User;
use App\Models\Maker;
use App\Models\Model;
use App\Models\CarImages;
use App\Models\City;
use App\Models\CarType;
use App\Models\FuelType;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class carController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars=User::find(51)->cars()->with(['primaryImage','maker','carModel'])->orderBy('created_at','desc')->get();
        return view('car.index',[
            'cars'=>$cars
        ]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('car.create');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Car $car)
    {
        return view('car.show',[
            'car'=>$car,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        return view('car.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        //
    }
    public function search()
    {
        $query=Car::where('published_at','<',now())->with(['primaryImage','city','carType','fuelType','maker','carModel'])->orderBy('published_at','desc');
        $carCount=$query->count();
        // $cars=$query->limit(20)->get();
        $cars=$query->paginate(10)->withQueryString();
        return view('car.search',[
            'cars'=>$cars
        ]);
    }   
    public function watchlist()
    {
        $user=User::find(51);
            $cars = $user->favoriteCars()
            ->with(['primaryImage','city','carType','fuelType','maker','carModel'])
            ->orderBy('published_at','desc')
            ->paginate(10);
        return view('car.watchlist',[
            'cars'=>$cars
        ]);
    }
}
