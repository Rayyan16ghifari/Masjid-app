<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kajian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-4">Tambah Kajian Baru</h1>
                
                <form action="{{ route('admin.kajian.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Judul -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Judul Kajian *</label>
                            <input type="text" name="judul" required 
                                   value="{{ old('judul') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Masukkan judul kajian">
                        </div>
                        
                        <!-- Ustadz -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ustadz *</label>
                            <select name="ustadz_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Ustadz</option>
                                @foreach($ustadzs as $ustadz)
                                    <option value="{{ $ustadz->id }}" {{ old('ustadz_id') == $ustadz->id ? 'selected' : '' }}>
                                        {{ $ustadz->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Kitab -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kitab</label>
                            <select name="kitab_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Pilih Kitab (Opsional)</option>
                                @foreach($kitabs as $kitab)
                                    <option value="{{ $kitab->id }}" {{ old('kitab_id') == $kitab->id ? 'selected' : '' }}>
                                        {{ $kitab->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <!-- Tanggal -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal *</label>
                            <input type="date" name="tanggal" required 
                                   value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <!-- Waktu -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu *</label>
                            <input type="text" name="waktu" required 
                                   value="{{ old('waktu', '08:00 WIB') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: 08:00 WIB">
                        </div>
                        
                        <!-- Lokasi -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                            <input type="text" name="lokasi" 
                                   value="{{ old('lokasi') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Masukkan lokasi kajian">
                        </div>
                        
                        <!-- Deskripsi -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
                            <textarea name="deskripsi" required rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Masukkan deskripsi kajian">{{ old('deskripsi') }}</textarea>
                        </div>
                        
                        <!-- Link YouTube -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link YouTube</label>
                            <input type="url" name="link_youtube" 
                                   value="{{ old('link_youtube') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="https://youtube.com/watch?v=...">
                        </div>
                        
                        <!-- Link Streaming -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Link Streaming</label>
                            <input type="url" name="link_streaming" 
                                   value="{{ old('link_streaming') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="https://zoom.us/j/...">
                        </div>
                        
                        <!-- Gambar -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Kajian</label>
                            <input type="file" name="image" accept="image/*" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="text-sm text-gray-500 mt-1">Opsional: Upload gambar thumbnail kajian</p>
                        </div>
                        
                        <!-- Status -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }} class="mr-2">
                                    <span>Aktif</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="tidak aktif" {{ old('status') == 'tidak aktif' ? 'checked' : '' }} class="mr-2">
                                    <span>Tidak Aktif</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                        <a href="{{ route('admin.kajian.index') }}" 
                           class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                        <div class="flex items-center space-x-3">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Kajian
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
