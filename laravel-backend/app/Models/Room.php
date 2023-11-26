<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';

    protected $fillable = [
        'name',
        'description',
        'facilities',
        'capacity',
        'size',
        'price',
        'status',
        'images_path'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function book()
    {
        $this->status = 'booked';
        $this->save();
    }
}
