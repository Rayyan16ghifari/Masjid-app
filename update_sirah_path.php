<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔄 Updating Sirah Nabawiyah PDF Path...\n\n";

$kitab = \App\Models\Kitab::where('nama', 'Sirah Nabawiyah')->first();
if ($kitab) {
    $oldPath = $kitab->pdf_path;
    $kitab->pdf_path = 'kitab/Sirah Nabawiyah Ibnu Hisyam.pdf';
    $kitab->save();
    
    echo "✅ PDF path updated successfully!\n";
    echo "📋 Details:\n";
    echo "   Kitab: {$kitab->nama}\n";
    echo "   ID: {$kitab->id}\n";
    echo "   Old Path: {$oldPath}\n";
    echo "   New Path: {$kitab->pdf_path}\n\n";
    
    echo "📁 File location: public/kitab/Sirah Nabawiyah Ibnu Hisyam.pdf\n";
    echo "🌐 Access at: http://127.0.0.1:8000/kitab/{$kitab->id}\n\n";
    
    echo "🎯 Test the PDF viewer:\n";
    echo "1. Visit http://127.0.0.1:8000/kitab\n";
    echo "2. Find 'Sirah Nabawiyah' in the list\n";
    echo "3. Click 'Baca Kitab' to open PDF viewer\n\n";
    
    echo "✨ Sirah Nabawiyah is now ready with correct PDF path!\n";
} else {
    echo "❌ Kitab 'Sirah Nabawiyah' not found in database\n";
    echo "Please run add_sirah_nabawiyah.php first\n";
}
