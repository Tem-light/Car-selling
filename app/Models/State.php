<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class State extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name'
    ];
    public function Cities():hasMany
    {
        return $this->hasMany(City::class);
    }
    public function Cars():hasMany
    {
        return $this->hasMany(Car::class);
    }
}
