<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'rental_id', 'payment_date', 'amount', 'payment_method', 'reference', 'notes',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
