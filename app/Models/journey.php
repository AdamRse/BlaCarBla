<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class journey extends Model
{
    use HasFactory;
    protected $fillable = [
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
