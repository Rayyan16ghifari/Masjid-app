<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dkm extends Model
{
    protected $table = 'dkms';
    protected $fillable = ['nama', 'jabatan', 'foto', 'email', 'no_hp', 'alamat', 'bio'];
}
