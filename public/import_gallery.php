<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// File foto yang ada di folder masjid
$photos = [
    'Masjid1.jpg' => 'Masjid Al-Hasanah - Tampak Depan',
    'Masjid2.jpg' => 'Halaman Luar Masjid',
    'Masjid3.jpg' => 'Kegiatan TPA',
    'Masjid4.jpg' => 'Menu Sahur',
    'Masjid5.jpg' => 'Halaman Dalam Masjid',
    'Masjid6.jpg' => 'Area Wudhu',
    'Masjid7.jpg' => 'Sholat Berjamaah',
    'Masjid8.jpg' => 'Kajian Rutin',
    'Masjid9.jpg' => 'Fasilitas Masjid',
    'Masjid10.jpg' => 'Renovasi Masjid',
    'Masjid11.jpg' => 'Peringatan Maulid',
    'Masjid12.jpg' => 'Buka Puasa Bersama',
    'Masjid13.jpg' => 'Kegiatan Remaja Masjid',
    'Masjid14.jpg' => 'Pelatihan Quran',
    'photo1.jpg' => 'Kajian Pengajian',
];

$categories = [
    'Masjid1.jpg' => 'bangunan',
    'Masjid2.jpg' => 'area-masjid',
    'Masjid3.jpg' => 'pendidikan',
    'Masjid4.jpg' => 'ramadhan',
    'Masjid5.jpg' => 'interior',
    'Masjid6.jpg' => 'fasilitas',
    'Masjid7.jpg' => 'ibadah',
    'Masjid8.jpg' => 'kajian',
    'Masjid9.jpg' => 'fasilitas',
    'Masjid10.jpg' => 'pembangunan',
    'Masjid11.jpg' => 'kegiatan',
    'Masjid12.jpg' => 'ramadhan',
    'Masjid13.jpg' => 'pemuda',
    'Masjid14.jpg' => 'pendidikan',
    'photo1.jpg' => 'kajian',
];

echo "Memulai import foto gallery...\n";

// Buat folder gallery jika belum ada
$galleryPath = __DIR__ . '/images/gallery';
if (!is_dir($galleryPath)) {
    mkdir($galleryPath, 0755, true);
    echo "Folder gallery dibuat: $galleryPath\n";
}

$importedCount = 0;
foreach ($photos as $filename => $title) {
    $sourcePath = __DIR__ . '/images/masjid/' . $filename;
    $targetPath = $galleryPath . '/' . $filename;
    
    if (file_exists($sourcePath)) {
        // Copy file ke folder gallery
        if (copy($sourcePath, $targetPath)) {
            // Simpan ke database
            try {
                \App\Models\Gallery::updateOrCreate(
                    ['gambar' => $filename],
                    [
                        'judul' => $title,
                        'kategori' => $categories[$filename] ?? 'lainnya',
                        'deskripsi' => 'Foto dokumentasi Masjid Al-Hasanah',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
                
                echo "✅ Berhasil import: $filename - $title\n";
                $importedCount++;
            } catch (\Exception $e) {
                echo "❌ Error database untuk $filename: " . $e->getMessage() . "\n";
            }
        } else {
            echo "❌ Gagal copy file: $filename\n";
        }
    } else {
        echo "⚠️ File tidak ditemukan: $filename\n";
    }
}

echo "\n=== Import Selesai ===\n";
echo "Total foto yang diimport: $importedCount\n";
echo "Silakan akses: http://127.0.0.1:8000/galeri\n";
