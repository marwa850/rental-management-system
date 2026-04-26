<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class House extends Model
{
    use SoftDeletes;

    protected $table = 'houses';

    protected $fillable = [
        'address', 'description', 'image',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
