<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Galeri - Admin Masjid Al-Hasanah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .upload-area {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 2px dashed #16a34a;
            transition: all 0.3s ease;
        }
        .upload-area:hover {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border-color: #15803d;
            transform: translateY(-2px);
        }
        .upload-area.dragover {
            background: linear-gradient(135deg, #bbf7d0 0%, #86efac 100%);
            border-color: #16a34a;
            transform: scale(1.02);
        }
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-emerald-50 via-green-50 to-white min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-emerald-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-images text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Tambah Galeri</h1>
                        <p class="text-sm text-gray-600">Upload foto dokumentasi kegiatan masjid</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.galeri.index') }}" 
                       class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors flex items-center space-x-2">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Upload Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl p-8 fade-in">
                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Image Upload Area -->
                        <div>
                            <label class="block text-lg font-semibold text-gray-900 mb-4">
                                <i class="fas fa-image text-emerald-600 mr-2"></i>
                                Upload Foto
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div id="dropZone" class="upload-area rounded-xl p-8 text-center cursor-pointer">
                                <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" required>
                                
                                <div id="previewContainer" class="hidden">
                                    <img id="imagePreview" src="" alt="Preview" class="mx-auto max-h-64 rounded-lg shadow-lg mb-4">
                                    <div class="flex justify-center space-x-3">
                                        <button type="button" onclick="removeImage()" 
                                                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors flex items-center space-x-2">
                                            <i class="fas fa-trash"></i>
                                            <span>Hapus Gambar</span>
                                        </button>
                                        <button type="button" onclick="document.getElementById('gambar').click()" 
                                                class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg transition-colors flex items-center space-x-2">
                                            <i class="fas fa-sync"></i>
                                            <span>Ganti Gambar</span>
                                        </button>
                                    </div>
                                </div>
                                
                                <div id="uploadPlaceholder">
                                    <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-emerald-600"></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Drag & Drop Foto</h3>
                                    <p class="text-gray-600 mb-4">atau klik untuk memilih file dari komputer</p>
                                    <div class="text-sm text-gray-500 space-y-1">
                                        <p><i class="fas fa-check-circle text-emerald-500 mr-1"></i>Format: JPG, PNG, GIF, WebP</p>
                                        <p><i class="fas fa-check-circle text-emerald-500 mr-1"></i>Ukuran maksimal: 10MB</p>
                                        <p><i class="fas fa-check-circle text-emerald-500 mr-1"></i>Resolusi minimal: 800x600px</p>
                                    </div>
                                    <button type="button" onclick="document.getElementById('gambar').click()" 
                                            class="mt-6 px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white rounded-lg transition-all transform hover:scale-105 flex items-center space-x-2 mx-auto">
                                        <i class="fas fa-folder-open"></i>
                                        <span>Pilih File</span>
                                    </button>
                                </div>
                            </div>
                            @error('gambar')
                                <div class="mt-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                                    <p class="text-red-600 text-sm flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror
                        </div>

                        <!-- Form Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Judul -->
                            <div>
                                <label for="judul" class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-heading text-emerald-600 mr-2"></i>
                                    Judul Foto
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <input type="text" 
                                       id="judul" 
                                       name="judul" 
                                       value="{{ old('judul') }}"
                                       placeholder="Contoh: Kajian Rutin Minggu" 
                                       class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                       required>
                                @error('judul')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label for="kategori" class="block text-sm font-semibold text-gray-900 mb-2">
                                    <i class="fas fa-tag text-emerald-600 mr-2"></i>
                                    Kategori
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <select id="kategori" 
                                        name="kategori" 
                                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                                        required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="kajian">Kajian</option>
                                    <option value="ramadhan">Ramadhan</option>
                                    <option value="idul-fitri">Idul Fitri</option>
                                    <option value="idul-adha">Idul Adha</option>
                                    <option value="pengajian">Pengajian</option>
                                    <option value="sosial">Kegiatan Sosial</option>
                                    <option value="bangunan">Bangunan Masjid</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                                @error('kategori')
                                    <p class="text-red-500 text-sm mt-2 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label for="deskripsi" class="block text-sm font-semibold text-gray-900 mb-2">
                                <i class="fas fa-align-left text-emerald-600 mr-2"></i>
                                Deskripsi
                            </label>
                            <textarea id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4" 
                                      placeholder="Tambahkan deskripsi foto (opsional)..."
                                      class="form-input w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('deskripsi') }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Deskripsi akan membantu pengguna memahami konteks foto</p>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.galeri.index') }}" 
                               class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors flex items-center space-x-2">
                                <i class="fas fa-times"></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white rounded-lg transition-all transform hover:scale-105 flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span>Simpan Foto</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-1">
                <div class="space-y-6">
                    <!-- Tips Card -->
                    <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-2xl p-6 border border-emerald-200 fade-in">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-lightbulb text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Tips Upload</h3>
                        </div>
                        <ul class="space-y-3 text-sm text-gray-700">
                            <li class="flex items-start">
                                <i class="fas fa-check text-emerald-500 mr-2 mt-1"></i>
                                <span>Gunakan foto berkualitas tinggi untuk hasil terbaik</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-emerald-500 mr-2 mt-1"></i>
                                <span>Beri judul yang deskriptif dan mudah dipahami</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-emerald-500 mr-2 mt-1"></i>
                                <span>Pilih kategori yang sesuai dengan konten foto</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-emerald-500 mr-2 mt-1"></i>
                                <span>Tambahkan deskripsi untuk memberikan konteks</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Recent Uploads -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 fade-in">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-history text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Upload Terbaru</h3>
                        </div>
                        <div class="space-y-3">
                            @php
                                $recentGallery = \App\Models\Gallery::latest()->take(3)->get();
                            @endphp
                            @if($recentGallery->count() > 0)
                                @foreach($recentGallery as $gallery)
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <img src="{{ asset('images/gallery/' . $gallery->gambar) }}" 
                                             alt="{{ $gallery->judul }}" 
                                             class="w-12 h-12 rounded-lg object-cover">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $gallery->judul }}</p>
                                            <p class="text-xs text-gray-500">{{ $gallery->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-500 text-sm">Belum ada foto diupload</p>
                            @endif
                        </div>
                    </div>

                    <!-- Statistics -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 border border-blue-200 fade-in">
                        <div class="flex items-center space-x-3 mb-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-bar text-white"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Statistik</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-2xl font-bold text-blue-600">{{ \App\Models\Gallery::count() }}</p>
                                <p class="text-sm text-gray-600">Total Foto</p>
                            </div>
                            <div class="text-center">
                                <p class="text-2xl font-bold text-indigo-600">{{ \App\Models\Gallery::whereMonth('created_at', now()->month)->count() }}</p>
                                <p class="text-sm text-gray-600">Bulan Ini</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Drag and Drop functionality
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('gambar');
        const previewContainer = document.getElementById('previewContainer');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const imagePreview = document.getElementById('imagePreview');

        // Click to upload
        dropZone.addEventListener('click', () => {
            fileInput.click();
        });

        // File selection
        fileInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file) {
                showPreview(file);
            }
        });

        // Drag and drop events
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('dragover');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('dragover');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                const file = files[0];
                if (file.type.startsWith('image/')) {
                    fileInput.files = files;
                    showPreview(file);
                } else {
                    alert('File harus berupa gambar!');
                }
            }
        });

        // Show image preview
        function showPreview(file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                uploadPlaceholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }

        // Remove image
        function removeImage() {
            fileInput.value = '';
            previewContainer.classList.add('hidden');
            uploadPlaceholder.classList.remove('hidden');
            imagePreview.src = '';
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', (e) => {
            const file = fileInput.files[0];
            if (!file) {
                e.preventDefault();
                alert('Silakan pilih foto terlebih dahulu!');
                return;
            }
            
            // Check file size (10MB max)
            if (file.size > 10 * 1024 * 1024) {
                e.preventDefault();
                alert('Ukuran file terlalu besar! Maksimal 10MB.');
                return;
            }
            
            // Check file type
            if (!file.type.startsWith('image/')) {
                e.preventDefault();
                alert('File harus berupa gambar!');
                return;
            }
        });
    </script>
</body>
</html>
