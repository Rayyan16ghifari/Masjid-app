<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "🔄 Updating Kitab PDF Paths...\n\n";

$kitabPaths = [
    'Riyadhus Shalihin' => 'kitab/riyadhus-shalihin.pdf',
    'Al-Ushul As-Sittah' => 'kitab/al-ushul-as-sittah.pdf',
    'Bulughul Maram' => 'kitab/bulughul-maram.pdf',
    'Syarah Arbain Nawawi' => 'kitab/syarah-arbain-nawawi.pdf',
    'Tafsir Ibnu Katsir' => 'kitab/tafsir-ibnu-katsir-juz1.pdf',
    'Fathul Bari' => 'kitab/fathul-bari.pdf',
];

$successCount = 0;
$failCount = 0;

foreach ($kitabPaths as $nama => $path) {
    $kitab = \App\Models\Kitab::where('nama', $nama)->first();
    if ($kitab) {
        $kitab->pdf_path = $path;
        $kitab->save();
        echo "✅ Updated: {$nama}\n";
        echo "   Path: {$path}\n";
        echo "   ID: {$kitab->id}\n\n";
        $successCount++;
    } else {
        echo "❌ Not found: {$nama}\n\n";
        $failCount++;
    }
}

echo "📊 Summary:\n";
echo "✅ Successfully updated: {$successCount} kitabs\n";
echo "❌ Not found: {$failCount} kitabs\n\n";

echo "📁 PDF files should be placed in: public/kitab/\n";
echo "🌐 Access your kitabs at: http://127.0.0.1:8000/kitab\n\n";

echo "🎯 Next steps:\n";
echo "1. Copy your PDF files to public/kitab/ folder\n";
echo "2. Make sure file names match the paths above\n";
echo "3. Test by visiting http://127.0.0.1:8000/kitab\n\n";

echo "✨ All done! Your Kitab Kajian system is ready!\n";
