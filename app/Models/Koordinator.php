<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Koordinator extends Model
{
    protected $table = 'koordinators';

    protected $fillable = ['nama', 'jabatan'];

    public function seksi()
    {
        return $this->hasMany(Seksi::class, 'koordinator_id');
    }
}
