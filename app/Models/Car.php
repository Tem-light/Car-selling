<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
            'maker_id',
            'model_id',
            'year',          
            'price',         
            'vin',          
            'mileage',
            'user_id',
            'city_id',
            'car_type_id',
            'fuel_type_id',
            'address',
            'phone',
            'description',
            'published_at',
    ];
}
