<?php

namespace App\Models;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'capacity', 'price', 'is_available'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}