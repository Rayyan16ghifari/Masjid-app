<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seksi extends Model
{
    protected $table = 'seksi';

    protected $fillable = [
        'nama',
        'koordinator_id'
    ];

    // =========================
    // RELASI KE KOORDINATOR
    // =========================
    public function koordinator()
    {
        return $this->belongsTo(Koordinator::class, 'koordinator_id');
    }

    // =========================
    // RELASI KE DKM (INI YANG ERROR TADI)
    // =========================
    public function dkms()
    {
        return $this->hasMany(Dkm::class, 'seksi_id');
    }
}
