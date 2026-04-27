<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dkm extends Model
{
    protected $table = 'dkms';

    protected $fillable = [
        'seksi_id',
        'nama',
        'jabatan',
        'foto',
        'email',
        'no_hp',
        'alamat',
        'bio',
    ];

    public function seksi()
    {
        return $this->belongsTo(Seksi::class);
    }

    public function koordinator()
    {
        return $this->hasOneThrough(
            Koordinator::class,
            Seksi::class,
            'id',
            'id',
            'seksi_id',
            'koordinator_id'
        );
    }
}
