<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sales extends Model
{
    protected $fillable = ['cart_data', 'total', 'user_id'];

    protected $casts = [
        'cart_data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
