<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ustadz extends Model
{
    protected $table = 'ustadz'; // karena tidak plural

    protected $fillable = [
        'nama'
    ];

    // Relasi ke kajian
    public function kajians()
    {
        return $this->hasMany(Kajian::class);
    }
}
