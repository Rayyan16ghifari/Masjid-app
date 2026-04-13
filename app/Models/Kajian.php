<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kajian extends Model
{
    protected $fillable = [
        'judul',
        'ustadz_id',
        'kitab_id',
        'hari',
        'pekan',
        'waktu',
        'lokasi',
        'deskripsi'
    ];

    // Relasi ke ustadz
    public function ustadz()
    {
        return $this->belongsTo(Ustadz::class);
    }

    // Relasi ke kitab
    public function kitab()
    {
        return $this->belongsTo(Kitab::class);
    }

    public function ratings()
    {
        return $this->hasMany(\App\Models\Rating::class);
    }
}
