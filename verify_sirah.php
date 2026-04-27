<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔍 Verifying Sirah Nabawiyah Setup...\n\n";

$kitab = \App\Models\Kitab::find(11);
if ($kitab) {
    echo "✅ Kitab Found:\n";
    echo "   ID: {$kitab->id}\n";
    echo "   Nama: {$kitab->nama}\n";
    echo "   Penulis: {$kitab->penulis}\n";
    echo "   PDF Path: {$kitab->pdf_path}\n";
    echo "   Halaman: {$kitab->jumlah_halaman}\n";
    echo "   Kategori: {$kitab->kategori}\n";
    echo "   Featured: " . ($kitab->is_featured ? 'Yes' : 'No') . "\n";
    echo "   Active: " . ($kitab->is_active ? 'Yes' : 'No') . "\n\n";
    
    $fullPath = public_path($kitab->pdf_path);
    echo "📁 File Verification:\n";
    echo "   Path: {$fullPath}\n";
    echo "   Exists: " . (file_exists($fullPath) ? 'YES' : 'NO') . "\n";
    
    if (file_exists($fullPath)) {
        $fileSize = filesize($fullPath);
        echo "   Size: " . number_format($fileSize / 1024 / 1024, 2) . " MB\n";
        echo "   Last Modified: " . date('Y-m-d H:i:s', filemtime($fullPath)) . "\n";
    }
    
    echo "\n🌐 Access URLs:\n";
    echo "   Kitab List: http://127.0.0.1:8000/kitab\n";
    echo "   Detail Page: http://127.0.0.1:8000/kitab/{$kitab->id}\n";
    echo "   PDF Viewer: http://127.0.0.1:8000/kitab/{$kitab->id}/pdf\n";
    echo "   PDF Download: http://127.0.0.1:8000/kitab/{$kitab->id}/download\n";
    
    echo "\n🎯 Ready to Test!\n";
    echo "1. Visit http://127.0.0.1:8000/kitab\n";
    echo "2. Look for 'Sirah Nabawiyah' (should be in featured section)\n";
    echo "3. Click 'Baca Kitab' to test PDF viewer\n";
    echo "4. Test zoom, navigation, and fullscreen features\n\n";
    
    echo "✨ Sirah Nabawiyah is fully activated and ready!\n";
} else {
    echo "❌ Kitab with ID 11 not found!\n";
    echo "Please check if the kitab was added correctly.\n";
}
