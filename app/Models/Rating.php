<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'kajian_id',
        'rating'
    ];

    public function kajian()
    {
        return $this->belongsTo(Kajian::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
