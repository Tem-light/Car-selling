<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\belongsTo;
class CarImage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'image_path',
        'position'
    ];
    public function Car():belongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
