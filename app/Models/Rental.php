<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    protected $table = 'rentals';
    
    protected $fillable = [
        'house_id', 'renter_id', 'start_date', 'end_date', 'price_per_month', 'notes',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function renter()
    {
        return $this->belongsTo(Renter::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
