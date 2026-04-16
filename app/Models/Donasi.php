<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    protected $table = 'donasis';

    protected $fillable = [
        'user_id',
        'nominal',
        'jenis',
        'status',
        'metode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
