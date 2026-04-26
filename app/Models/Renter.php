<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Renter extends Model
{
    use SoftDeletes;

    protected $table = 'renters';

    protected $fillable = [
        'name', 'Tel', 'cin',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
