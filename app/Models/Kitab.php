<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kitab extends Model
{
    protected $table = 'kitab'; // karena tidak plural

    protected $fillable = [
        'nama',
        'judul',
        'penulis',
        'deskripsi',
        'pdf_path',
        'cover_image',
        'jumlah_halaman',
        'kategori',
        'bahasa',
        'views',
        'is_featured',
        'is_active',
        'tanggal_terbit'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'views' => 'integer',
        'jumlah_halaman' => 'integer',
    ];

    // Accessor untuk PDF URL
    public function getPdfUrlAttribute()
    {
        $path = $this->resolvePublicAssetPath($this->pdf_path);

        return $path ? asset($path) : null;
    }

    // Accessor untuk cover image URL
    public function getCoverImageUrlAttribute()
    {
        $path = $this->resolvePublicAssetPath($this->cover_image);

        if ($path) {
            return asset($path);
        }
        
        // Default cover image jika tidak ada
        return 'https://via.placeholder.com/300x400/1a3a2a/9FE1CB?text=' . urlencode($this->nama ?? 'Kitab');
    }

    public function resolvePublicAssetPath(?string $path): ?string
    {
        $normalized = ltrim(str_replace('\\', '/', (string) $path), '/');

        if ($normalized === '') {
            return null;
        }

        if (substr($normalized, 0, 6) === 'kitab/') {
            $migrated = 'files/' . $normalized;

            if (file_exists(public_path($migrated)) || !file_exists(public_path($normalized))) {
                return $migrated;
            }
        }

        return $normalized;
    }

    public function resolvePublicAssetAbsolutePath(?string $path): ?string
    {
        $resolvedPath = $this->resolvePublicAssetPath($path);

        return $resolvedPath ? public_path($resolvedPath) : null;
    }

    // Scope untuk kitab yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk kitab featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Format views yang readable
    public function getFormattedViewsAttribute()
    {
        if ($this->views >= 1000) {
            return number_format($this->views / 1000, 1) . 'K views';
        }
        return $this->views . ' views';
    }

    // Relasi ke kajian
    public function kajians()
    {
        return $this->hasMany(Kajian::class);
    }

    // Increment views
    public function incrementViews()
    {
        $this->increment('views');
    }
}
