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

    public function driver(){
        return $this->belongsTo(User::class, 'driver');
    }

    public function departure(){
        return $this->belongsTo(cities::class, 'departure');
    }

    public function arrival(){
        return $this->belongsTo(cities::class, 'arrival');
    }
}
