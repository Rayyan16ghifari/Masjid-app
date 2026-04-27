<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "📝 Adding Missing PDF Files Guide...\n\n";

$missingPdfKitabs = \App\Models\Kitab::active()->where(function($query) {
    $query->whereNull('pdf_path')
          ->orWhere('pdf_path', '')
          ->orWhere(function($q) {
              $q->whereNotNull('pdf_path')
                ->where('pdf_path', '!=', '')
                ->whereRaw('pdf_path NOT IN (?)', ['kitab/Riyadhus-Shalihin-Taman-Orang-Orang-Sholeh.pdf', 'kitab/enam-pondasi-terjemahan-al-ushul-as-sittah.pdf', 'kitab/Sirah Nabawiyah Ibnu Hisyam.pdf']);
          });
})->get();

echo "📚 Kitabs that need PDF files:\n\n";

foreach ($missingPdfKitabs as $kitab) {
    echo "📖 " . $kitab->nama . " (ID: " . $kitab->id . ")\n";
    echo "   Current PDF Path: " . ($kitab->pdf_path ?: 'EMPTY') . "\n";
    echo "   Suggested File Name: " . strtolower(str_replace(' ', '-', $kitab->nama)) . ".pdf\n";
    echo "   Status: " . (file_exists(public_path($kitab->pdf_path)) ? 'File exists' : 'File missing') . "\n";
    echo "---\n";
}

echo "\n🎯 To add PDF files:\n";
echo "1. Copy PDF files to: public/kitab/\n";
echo "2. Use these file names:\n";
echo "   - bulughul-maram.pdf\n";
echo "   - syarah-arbain-nawawi.pdf\n";
echo "   - tafsir-ibnu-katsir-juz1.pdf\n";
echo "   - fathul-bari.pdf\n\n";

echo "3. Then run this command to update paths:\n";
echo "   php update_missing_pdf_paths.php\n\n";

echo "✨ Guide completed!\n";
