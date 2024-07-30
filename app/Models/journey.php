<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class journey extends Model
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'driver',
        'departure',
        'arrival',
        'addr_departure',
        'addr_arrival',
        'time_departure',
        'time_travel',
        'seats',
    ];

    public function cities(){
        return $this->hasMany(cities::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }
}
