<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\hasMany;

class CarModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'maker_id'
    ];

    public function maker():hasMany
    {
        return $this->hasMany(Maker::class);
    }
}
