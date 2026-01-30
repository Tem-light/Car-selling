<?php

namespace App\Http\Controllers;
use App\Models\Car;
use App\Models\Maker;
use App\Models\User;
use App\Models\Model;
use App\Models\CarImages;

use Illuminate\Http\Request;

class homeController extends Controller
{
    public function index()
    {
      User::find(1)->favoriteCars()->attach([4]);


        return view('index');

    }
}
