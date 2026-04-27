<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Foto Galeri</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Tambah Foto Galeri</h1>
                
                <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Foto *</label>
                        <input type="file" name="gambar" accept="image/*" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                        <input type="text" name="judul" required class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Masukkan judul foto">
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                        <select name="kategori" required class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                            <option value="">Pilih Kategori</option>
                            <option value="kegiatan">Kegiatan</option>
                            <option value="masjid">Masjid</option>
                            <option value="kajian">Kajian</option>
                            <option value="donasi">Donasi</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg" placeholder="Tambahkan deskripsi foto"></textarea>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Upload Foto
                        </button>
                        <a href="{{ route('admin.galeri.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
