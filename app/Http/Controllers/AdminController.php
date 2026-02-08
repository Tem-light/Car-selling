<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Car;

class AdminController extends Controller
{
    public function dashboard()
    {
        $cars = Car::with(['maker', 'carModel'])->latest()->take(5)->get();
        $users = User::latest()->take(5)->get();
        $totalCars = Car::count();
        $totalUsers = User::count();

        return view('admin.dashboard', compact('cars', 'users', 'totalCars', 'totalUsers'));
    }

    public function allCars()
    {
        $cars = Car::latest()->paginate(10);
        return view('admin.cars.index', compact('cars'));
    }

    public function deleteCar(Car $car)
    {
        $car->delete();
        return back()->with('success', 'Car deleted successfully.');
    }
}
