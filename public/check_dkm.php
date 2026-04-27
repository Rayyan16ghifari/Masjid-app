<?php
require_once __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Dkm;

echo "=== CEK DATA DKM ===" . PHP_EOL;

$dkmList = Dkm::all();

echo "Total anggota DKM: " . $dkmList->count() . PHP_EOL . PHP_EOL;

foreach ($dkmList as $dkm) {
    echo "Nama: " . $dkm->nama . PHP_EOL;
    echo "Jabatan: " . $dkm->jabatan . PHP_EOL;
    echo "No HP: " . ($dkm->no_hp ?? 'Tidak ada') . PHP_EOL;
    echo "Email: " . ($dkm->email ?? 'Tidak ada') . PHP_EOL;
    echo "---" . PHP_EOL;
}

// Cari ketua berdasarkan logika yang sama dengan di controller
$ketua = Dkm::get()
    ->sortBy(function ($member) {
        $jabatanRank = [
            'Ketua' => 1,
            'Wakil Ketua' => 2,
            'Sekretaris' => 3,
            'Bendahara' => 4,
            'Anggota' => 5,
        ];
        return sprintf('%03d-%s', $jabatanRank[$member->jabatan] ?? 5, strtolower($member->nama ?? ''));
    })
    ->first();

echo PHP_EOL . "=== KETUA YANG DIGUNAKAN ===" . PHP_EOL;
if ($ketua) {
    echo "Nama: " . $ketua->nama . PHP_EOL;
    echo "Jabatan: " . $ketua->jabatan . PHP_EOL;
    echo "No HP: " . ($ketua->no_hp ?? 'Tidak ada') . PHP_EOL;
} else {
    echo "Tidak ada ketua ditemukan, akan menggunakan default values" . PHP_EOL;
}
?>
