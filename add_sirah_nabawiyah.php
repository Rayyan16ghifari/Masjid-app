<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "📚 Adding Sirah Nabawiyah Kitab...\n\n";

// Check if kitab already exists
$existingKitab = \App\Models\Kitab::where('nama', 'Sirah Nabawiyah')->first();
if ($existingKitab) {
    echo "⚠️  Kitab 'Sirah Nabawiyah' already exists with ID: {$existingKitab->id}\n";
    echo "Updating PDF path...\n";
    $existingKitab->pdf_path = 'kitab/sirah-nabawiyah.pdf';
    $existingKitab->is_active = true;
    $existingKitab->save();
    echo "✅ Updated existing kitab\n\n";
} else {
    // Create new kitab
    $kitab = new \App\Models\Kitab();
    $kitab->nama = 'Sirah Nabawiyah';
    $kitab->judul = 'Sirah Nabawiyah - Biografi Nabi Muhammad SAW';
    $kitab->penulis = 'Syaikh Shafiyyur Rahman Al-Mubarakfuri';
    $kitab->deskripsi = 'Kitab yang komprehensif mengenai sejarah kehidupan Nabi Muhammad SAW, mulai dari kelahiran hingga wafatnya, serta berbagai aspek kehidupan beliau.';
    $kitab->pdf_path = 'kitab/sirah-nabawiyah.pdf';
    $kitab->cover_image = null;
    $kitab->jumlah_halaman = 520;
    $kitab->kategori = 'Sirah Nabawiyah';
    $kitab->bahasa = 'Arab';
    $kitab->views = 0;
    $kitab->is_featured = true;
    $kitab->is_active = true;
    $kitab->tanggal_terbit = '2024-04-25';
    $kitab->save();

    echo "✅ Sirah Nabawiyah kitab added successfully!\n";
    echo "📋 Details:\n";
    echo "   ID: {$kitab->id}\n";
    echo "   Nama: {$kitab->nama}\n";
    echo "   Penulis: {$kitab->penulis}\n";
    echo "   Halaman: {$kitab->jumlah_halaman}\n";
    echo "   Kategori: {$kitab->kategori}\n";
    echo "   PDF Path: {$kitab->pdf_path}\n";
    echo "   Featured: " . ($kitab->is_featured ? 'Yes' : 'No') . "\n";
    echo "   Active: " . ($kitab->is_active ? 'Yes' : 'No') . "\n\n";
}

echo "📁 PDF file should be placed at: public/kitab/sirah-nabawiyah.pdf\n";
echo "🌐 Access at: http://127.0.0.1:8000/kitab\n";
echo "📖 Direct access: http://127.0.0.1:8000/kitab/" . (\App\Models\Kitab::where('nama', 'Sirah Nabawiyah')->first()->id ?? '?') . "\n\n";

echo "🎯 Next steps:\n";
echo "1. Make sure 'sirah-nabawiyah.pdf' is in public/kitab/ folder\n";
echo "2. Visit http://127.0.0.1:8000/kitab to see it in the list\n";
echo "3. Click 'Baca Kitab' to test the PDF viewer\n\n";

echo "✨ Sirah Nabawiyah is now active in your Kitab Kajian system!\n";
