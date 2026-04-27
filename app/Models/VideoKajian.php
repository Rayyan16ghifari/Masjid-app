<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoKajian extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'pemateri',
        'video_id',
        'thumbnail',
        'durasi',
        'views',
        'kategori',
        'sumber',
        'sumber_channel',
        'tanggal_upload',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'tanggal_upload' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'views' => 'integer',
    ];

    // Accessor untuk YouTube URL
    public function getYoutubeUrlAttribute()
    {
        return "https://www.youtube.com/watch?v={$this->video_id}";
    }

    // Accessor untuk YouTube embed URL
    public function getYoutubeEmbedUrlAttribute()
    {
        return "https://www.youtube.com/embed/{$this->video_id}";
    }

    // Accessor untuk YouTube thumbnail URL
    public function getYoutubeThumbnailUrlAttribute()
    {
        return $this->thumbnail ?: "https://img.youtube.com/vi/{$this->video_id}/hqdefault.jpg";
    }

    // Scope untuk video yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk video featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope berdasarkan sumber
    public function scopeBySumber($query, $sumber)
    {
        return $query->where('sumber', $sumber);
    }

    // Scope berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Format durasi yang readable
    public function getFormattedDurasiAttribute()
    {
        if (!$this->durasi) return 'N/A';
        
        $parts = explode(':', $this->durasi);
        if (count($parts) === 3) {
            return sprintf('%d jam %d menit %d detik', $parts[0], $parts[1], $parts[2]);
        } elseif (count($parts) === 2) {
            return sprintf('%d menit %d detik', $parts[0], $parts[1]);
        }
        
        return $this->durasi;
    }

    // Format views yang readable
    public function getFormattedViewsAttribute()
    {
        if ($this->views >= 1000000) {
            return number_format($this->views / 1000000, 1) . 'M views';
        } elseif ($this->views >= 1000) {
            return number_format($this->views / 1000, 1) . 'K views';
        }
        
        return $this->views . ' views';
    }
}
