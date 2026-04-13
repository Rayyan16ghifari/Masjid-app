<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kitab extends Model
{
    protected $table = 'kitab'; // karena tidak plural

    protected $fillable = [
        'nama'
    ];

    // Relasi ke kajian
    public function kajians()
    {
        return $this->hasMany(Kajian::class);
    }
}
