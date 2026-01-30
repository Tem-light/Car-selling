<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
class CarFeatures extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'car_id';
    protected $fillable = [
        'car_id',
        'abs',
        'air_conditioning',
        'power_windows',
        'power_door_lock',
        'cruise_control',
        'bluetooth_connection',
        'remote_start',
        'gps_navigation',
        'heated_seats',
        'climate_control',
        'rear_parking_sensors',
        'leather_seats'
    ];
    public function Car()
    {
        return $this->belongsTo(Car::class);
    }
}
