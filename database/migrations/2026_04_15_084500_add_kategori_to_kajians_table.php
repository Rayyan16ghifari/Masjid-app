<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kajians', function (Blueprint $table) {
            $table->string('kategori')->default('Dakwah Umum')->after('judul');
        });

        $kajians = DB::table('kajians')
            ->leftJoin('kitab', 'kajians.kitab_id', '=', 'kitab.id')
            ->select(
                'kajians.id',
                'kajians.judul',
                'kajians.deskripsi',
                'kitab.nama as kitab_nama'
            )
            ->get();

        foreach ($kajians as $kajian) {
            DB::table('kajians')
                ->where('id', $kajian->id)
                ->update([
                    'kategori' => $this->detectKategori(
                        $kajian->judul,
                        $kajian->kitab_nama,
                        $kajian->deskripsi
                    ),
                ]);
        }
    }

    public function down(): void
    {
        Schema::table('kajians', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }

    private function detectKategori(?string $judul, ?string $kitabNama, ?string $deskripsi): string
    {
        $text = strtolower(trim(implode(' ', array_filter([
            $judul,
            $kitabNama,
            $deskripsi,
        ]))));

        $map = [
            'Aqidah' => ['aqidah', 'tauhid', 'ushul', 'iman'],
            'Sirah' => ['sirah', 'siroh', 'nabawiyah', 'rasul', 'sejarah'],
            'Al-Quran' => ['al-quran', 'alquran', 'quran', 'tafsir'],
            'Tazkiyah' => ['tazkiyah', 'tazkiyatun', 'penyucian jiwa', 'nufus'],
            'Akhlak' => ['akhlak', 'adab'],
            'Fiqih' => ['fiqih', 'fikih', 'thaharah', 'shalat', 'zakat', 'puasa', 'haji', 'ibadah'],
            'Hadits' => ['hadits', 'hadis', 'riyadussholihin', 'riyadhus shalihin', 'arba', 'bukhari', 'muslim'],
            'Muamalah' => ['muamalah', 'ekonomi', 'waris', 'jual beli', 'nikah'],
        ];

        foreach ($map as $kategori => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($text, $keyword)) {
                    return $kategori;
                }
            }
        }

        return 'Dakwah Umum';
    }
};
