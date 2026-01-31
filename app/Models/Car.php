<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes; 

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\belongsToMany;
use App\Models\User;
use App\Models\CarType;
use App\Models\CarImage;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\CarModel;
use App\Models\City;
    
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
     public function CarType():belongsTo
    {
        return $this->belongsTo(CarType::class);
    }
    public function Features():HasOne
    {
        return $this->hasOne(CarFeatures::class);
    }
    public function PrimaryImage():HasOne
    {
        return $this->hasOne(CarImage::class)
                ->oldestOfMany('position');
    }
    public function images():HasMany
    {
        return $this->hasMany(CarImage::class);
    }

    public function FavoredUsers():belongsToMany
    {
        return $this->belongsToMany(User::class,'favorite_cars');
    }
    public function FuelType():belongsTo
    {
        return $this->belongsTo(FuelType::class);
    }
    public function Maker():belongsTo
    {
        return $this->belongsTo(Maker::class);
    }
    public function carModel():belongsTo
    {
        return $this->belongsTo(CarModel::class);
    }
    Public function Owner():belongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function City():belongsTo
    {
        return $this->belongsTo(City::class);
    }
    public function getCreateDate():string
    {
        return ( new \Carbon\Carbon($this->created_at))->format('y-m-d');
    }
}
