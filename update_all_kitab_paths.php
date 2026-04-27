<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔄 Updating All Kitab PDF Paths...\n\n";

// File mapping based on actual files in folder
$kitabFileMapping = [
    'Riyadhus Shalihin' => 'kitab/Riyadhus-Shalihin-Taman-Orang-Orang-Sholeh.pdf',
    'Al-Ushul As-Sittah' => 'kitab/enam-pondasi-terjemahan-al-ushul-as-sittah.pdf',
    'Sirah Nabawiyah' => 'kitab/Sirah Nabawiyah Ibnu Hisyam.pdf'
];

$successCount = 0;
$failCount = 0;

foreach ($kitabFileMapping as $nama => $path) {
    $kitab = \App\Models\Kitab::where('nama', $nama)->first();
    if ($kitab) {
        $oldPath = $kitab->pdf_path;
        $kitab->pdf_path = $path;
        $kitab->save();
        
        echo "✅ Updated: {$nama}\n";
        echo "   ID: {$kitab->id}\n";
        echo "   Old Path: {$oldPath}\n";
        echo "   New Path: {$path}\n";
        
        // Check file exists
        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            $fileSize = filesize($fullPath);
            echo "   File Size: " . number_format($fileSize / 1024 / 1024, 2) . " MB\n";
            echo "   Status: ✅ File exists\n";
        } else {
            echo "   Status: ❌ File not found\n";
        }
        echo "\n";
        
        $successCount++;
    } else {
        echo "❌ Not found: {$nama}\n\n";
        $failCount++;
    }
}

echo "📊 Summary:\n";
echo "✅ Successfully updated: {$successCount} kitabs\n";
echo "❌ Not found: {$failCount} kitabs\n\n";

echo "🌐 Test URLs:\n";
foreach ($kitabFileMapping as $nama => $path) {
    $kitab = \App\Models\Kitab::where('nama', $nama)->first();
    if ($kitab) {
        echo "   {$nama}: http://127.0.0.1:8000/kitab/{$kitab->id}\n";
    }
}

echo "\n🎯 Next Steps:\n";
echo "1. Visit http://127.0.0.1:8000/kitab\n";
echo "2. Test each kitab's PDF viewer\n";
echo "3. Verify all PDF files load correctly\n\n";

echo "✨ All kitab paths have been updated!\n";
