<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Sample kitab data
$kitabs = [
    [
        'nama' => 'Riyadhus Shalihin',
        'judul' => 'Riyadhus Shalihin - Kitab Hadis Pilihan',
        'penulis' => 'Imam An-Nawawi',
        'deskripsi' => 'Kitab hadis yang menghimpun hadis-hadis pilihan yang berkaitan dengan akhlak, adab, dan petunjuk praktis dalam kehidupan sehari-hari.',
        'pdf_path' => 'kitab/riyadhus-shalihin.pdf',
        'cover_image' => 'kitab/riyadhus-shalihin-cover.jpg',
        'jumlah_halaman' => 318,
        'kategori' => 'Hadis',
        'bahasa' => 'Arab',
        'views' => 1250,
        'is_featured' => true,
        'is_active' => true,
        'tanggal_terbit' => '2024-01-15'
    ],
    [
        'nama' => 'Al-Ushul As-Sittah',
        'judul' => 'Al-Ushul As-Sittah - Enam Prinsip Dasar',
        'penulis' => 'Muhammad bin Abdul Wahhab',
        'deskripsi' => 'Kitab yang menjelaskan enam prinsip dasar aqidah Islam yang menjadi pondasi keimanan seorang muslim.',
        'pdf_path' => 'kitab/al-ushul-as-sittah.pdf',
        'cover_image' => 'kitab/al-ushul-as-sittah-cover.jpg',
        'jumlah_halaman' => 45,
        'kategori' => 'Aqidah',
        'bahasa' => 'Arab',
        'views' => 890,
        'is_featured' => true,
        'is_active' => true,
        'tanggal_terbit' => '2024-01-20'
    ],
    [
        'nama' => 'Bulughul Maram',
        'judul' => 'Bulughul Maram - Capaian Tujuan',
        'penulis' => 'Ibn Hajar Al-Asqalani',
        'deskripsi' => 'Kitab hadis yang menghimpun hadis-hadis yang dijadikan dalil dalam fiqih, lengkap dengan takhrij dan penjelasan sanad.',
        'pdf_path' => 'kitab/bulughul-maram.pdf',
        'cover_image' => 'kitab/bulughul-maram-cover.jpg',
        'jumlah_halaman' => 450,
        'kategori' => 'Hadis',
        'bahasa' => 'Arab',
        'views' => 670,
        'is_featured' => false,
        'is_active' => true,
        'tanggal_terbit' => '2024-01-25'
    ],
    [
        'nama' => 'Syarah Arbain Nawawi',
        'judul' => 'Syarah Arbain Nawawi - Penjelasan 40 Hadis',
        'penulis' => 'Imam An-Nawawi',
        'deskripsi' => 'Kumpulan 40 hadis pilihan yang mencakup dasar-dasar agama Islam, dilengkapi dengan penjelasan yang mendalam.',
        'pdf_path' => 'kitab/syarah-arbain-nawawi.pdf',
        'cover_image' => 'kitab/syarah-arbain-nawawi-cover.jpg',
        'jumlah_halaman' => 280,
        'kategori' => 'Hadis',
        'bahasa' => 'Arab',
        'views' => 1120,
        'is_featured' => true,
        'is_active' => true,
        'tanggal_terbit' => '2024-02-01'
    ],
    [
        'nama' => 'Tafsir Ibnu Katsir',
        'judul' => 'Tafsir Ibnu Katsir Juz 1',
        'penulis' => 'Ibnu Katsir',
        'deskripsi' => 'Tafsir Al-Quran yang menggunakan metode tafsir bil ma\'tsur, menjelaskan ayat-ayat Al-Quran dengan ayat lain dan hadis.',
        'pdf_path' => 'kitab/tafsir-ibnu-katsir-juz1.pdf',
        'cover_image' => 'kitab/tafsir-ibnu-katsir-cover.jpg',
        'jumlah_halaman' => 520,
        'kategori' => 'Tafsir',
        'bahasa' => 'Arab',
        'views' => 980,
        'is_featured' => false,
        'is_active' => true,
        'tanggal_terbit' => '2024-02-05'
    ],
    [
        'nama' => 'Fathul Bari',
        'judul' => 'Fathul Bari - Syarah Shahih Bukhari',
        'penulis' => 'Ibn Hajar Al-Asqalani',
        'deskripsi' => 'Syarah lengkap Shahih Bukhari yang merupakan kitab hadis paling sahih setelah Al-Quran.',
        'pdf_path' => 'kitab/fathul-bari.pdf',
        'cover_image' => 'kitab/fathul-bari-cover.jpg',
        'jumlah_halaman' => 680,
        'kategori' => 'Hadis',
        'bahasa' => 'Arab',
        'views' => 450,
        'is_featured' => false,
        'is_active' => true,
        'tanggal_terbit' => '2024-02-10'
    ]
];

foreach($kitabs as $kitabData) {
    \App\Models\Kitab::create($kitabData);
}

echo 'Sample kitab data created successfully!';
