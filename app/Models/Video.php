<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';

    protected $fillable = [
        'judul',
        'ustadz',        // STRING (bukan relasi)
        'youtube_url',
        'thumbnail'
    ];

    /*
    |--------------------------------------------------------------------------
    | GET YOUTUBE ID (AMAN SEMUA FORMAT)
    |--------------------------------------------------------------------------
    */
    public function getYoutubeIdAttribute()
    {
        if (!$this->youtube_url) {
            return null;
        }

        preg_match('/(youtu\.be\/|v=)([^&]+)/', $this->youtube_url, $matches);

        return $matches[2] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO THUMBNAIL
    |--------------------------------------------------------------------------
    */
    public function getThumbnailAttribute($value)
    {
        // kalau sudah ada di DB → pakai itu
        if (!empty($value)) {
            return $value;
        }

        // generate dari YouTube
        if ($this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/hqdefault.jpg";
        }

        // fallback kalau kosong
        return "https://via.placeholder.com/300x200?text=Video+Kajian";
    }

    /*
    |--------------------------------------------------------------------------
    | EMBED URL
    |--------------------------------------------------------------------------
    */
    public function getEmbedUrlAttribute()
    {
        if ($this->youtube_id) {
            return "https://www.youtube.com/embed/{$this->youtube_id}";
        }

        return null;
    }
}
