# Panduan Setup PDF Kitab Kajian

## 📁 Lokasi Penyimpanan PDF

PDF files untuk kitab kajian disimpan di:
```
c:\xampp\htdocs\kajian-app\public\kitab\
```

## 📋 Langkah-langkah Setup

### 1. Siapkan PDF Files
- Letakkan file PDF kitab di folder `public/kitab/`
- Beri nama file yang sesuai dengan kitab (gunakan lowercase dan hyphen)

### 2. Update Database
Update path PDF di database dengan format:
```
kitab/[nama-file].pdf
```

### 3. Contoh File Structure
```
public/kitab/
├── riyadhus-shalihin.pdf
├── al-ushul-as-sittah.pdf
├── bulughul-maram.pdf
├── syarah-arbain-nawawi.pdf
├── tafsir-ibnu-katsir-juz1.pdf
└── fathul-bari.pdf
```

## 🔄 Update Database Command

Jalankan command berikut untuk update path PDF:

```bash
php artisan tinker
```

Kemudian jalankan:

```php
// Update Riyadhus Shalihin
$kitab = \App\Models\Kitab::where('nama', 'Riyadhus Shalihin')->first();
$kitab->pdf_path = 'kitab/riyadhus-shalihin.pdf';
$kitab->save();

// Update Al-Ushul As-Sittah
$kitab = \App\Models\Kitab::where('nama', 'Al-Ushul As-Sittah')->first();
$kitab->pdf_path = 'kitab/al-ushul-as-sittah.pdf';
$kitab->save();

// Update Bulughul Maram
$kitab = \App\Models\Kitab::where('nama', 'Bulughul Maram')->first();
$kitab->pdf_path = 'kitab/bulughul-maram.pdf';
$kitab->save();

// Update Syarah Arbain Nawawi
$kitab = \App\Models\Kitab::where('nama', 'Syarah Arbain Nawawi')->first();
$kitab->pdf_path = 'kitab/syarah-arbain-nawawi.pdf';
$kitab->save();

// Update Tafsir Ibnu Katsir
$kitab = \App\Models\Kitab::where('nama', 'Tafsir Ibnu Katsir')->first();
$kitab->pdf_path = 'kitab/tafsir-ibnu-katsir-juz1.pdf';
$kitab->save();

// Update Fathul Bari
$kitab = \App\Models\Kitab::where('nama', 'Fathul Bari')->first();
$kitab->pdf_path = 'kitab/fathul-bari.pdf';
$kitab->save();
```

## 📝 Nama File yang Direkomendasikan

Berdasarkan kitab yang ada di database:

1. **Riyadhus Shalihin** → `riyadhus-shalihin.pdf`
2. **Al-Ushul As-Sittah** → `al-ushul-as-sittah.pdf`
3. **Bulughul Maram** → `bulughul-maram.pdf`
4. **Syarah Arbain Nawawi** → `syarah-arbain-nawawi.pdf`
5. **Tafsir Ibnu Katsir** → `tafsir-ibnu-katsir-juz1.pdf`
6. **Fathul Bari** → `fathul-bari.pdf`

## 🎯 Tips Tambahan

### Cover Images (Opsional)
Jika ingin menambahkan cover images, simpan di:
```
public/kitab/covers/
├── riyadhus-shalihin-cover.jpg
├── al-ushul-as-sittah-cover.jpg
└── ...
```

Kemudian update database:
```php
$kitab->cover_image = 'kitab/covers/riyadhus-shalihin-cover.jpg';
$kitab->save();
```

### File Size Optimization
- Usahakan PDF file size tidak terlalu besar (< 50MB per file)
- Compress PDF jika perlu menggunakan tools online

### Testing
Setelah setup, test dengan mengakses:
- `http://127.0.0.1:8000/kitab` (untuk melihat koleksi)
- `http://127.0.0.1:8000/kitab/1` (untuk test PDF viewer)

## ⚠️ Important Notes

1. **File Path**: Pastikan path di database menggunakan format `kitab/[nama-file].pdf`
2. **File Permission**: Pastikan folder `public/kitab/` bisa diakses oleh web server
3. **File Naming**: Gunakan lowercase dan hyphen (-) untuk spasi
4. **Backup**: Backup PDF files penting sebelum upload

## 🚀 Quick Setup Script

Jika ingin update semua path sekaligus, buat file `update_kitab_paths.php`:

```php
<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$kitabPaths = [
    'Riyadhus Shalihin' => 'kitab/riyadhus-shalihin.pdf',
    'Al-Ushul As-Sittah' => 'kitab/al-ushul-as-sittah.pdf',
    'Bulughul Maram' => 'kitab/bulughul-maram.pdf',
    'Syarah Arbain Nawawi' => 'kitab/syarah-arbain-nawawi.pdf',
    'Tafsir Ibnu Katsir' => 'kitab/tafsir-ibnu-katsir-juz1.pdf',
    'Fathul Bari' => 'kitab/fathul-bari.pdf',
];

foreach ($kitabPaths as $nama => $path) {
    $kitab = \App\Models\Kitab::where('nama', $nama)->first();
    if ($kitab) {
        $kitab->pdf_path = $path;
        $kitab->save();
        echo "Updated: {$nama} -> {$path}\n";
    }
}

echo "All kitab paths updated successfully!";
```

Jalankan dengan:
```bash
php update_kitab_paths.php
```
