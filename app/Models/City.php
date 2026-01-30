<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class City extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'state_id'
    ];
    public function State():belongsTo
    {
        return $this->belongsTo(State::class);
    }
    public function Cars():hasMany
    {
        return $this->hasMany(Car::class);
    }
}