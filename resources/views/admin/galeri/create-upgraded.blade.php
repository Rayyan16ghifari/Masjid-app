<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Media Galeri - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-in { animation: slideIn 0.5s ease-out; }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .pulse-hover:hover { animation: pulse 0.3s ease-in-out; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .upload-zone {
            background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
            border: 2px dashed #d1d5db;
            transition: all 0.3s ease;
        }
        .upload-zone.dragover {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            border-color: #3b82f6;
            transform: scale(1.02);
        }
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }
        .form-input {
            transition: all 0.3s ease;
        }
        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            border-color: #3b82f6;
        }
        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1rem;
        }
        .preview-item {
            position: relative;
            overflow: hidden;
            border-radius: 0.75rem;
        }
        .preview-item img {
            transition: transform 0.3s ease;
        }
        .preview-item:hover img {
            transform: scale(1.05);
        }
        .progress-bar {
            background: linear-gradient(90deg, #3b82f6, #2563eb);
            transition: width 0.3s ease;
        }
        .tab-button {
            transition: all 0.3s ease;
        }
        .tab-button.active {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
        }
        .category-badge {
            transition: all 0.2s ease;
        }
        .category-badge:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- Background Pattern -->
    <div class="fixed inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="relative z-10 min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8 mb-8 slide-in">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-plus text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                                Tambah Media Galeri
                            </h1>
                            <p class="text-gray-600 mt-1">Upload foto atau video dokumentasi kegiatan masjid</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.galeri.index') }}" 
                       class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium shadow-lg transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                </div>
            </div>

            <!-- Media Type Tabs -->
            <div class="glass-effect rounded-2xl shadow-xl p-6 mb-8">
                <div class="flex items-center space-x-4 mb-6">
                    <button onclick="switchTab('image')" id="imageTab" class="tab-button active px-6 py-3 rounded-xl font-medium">
                        <i class="fas fa-image mr-2"></i>
                        Foto
                    </button>
                    <button onclick="switchTab('video')" id="videoTab" class="tab-button px-6 py-3 rounded-xl font-medium bg-gray-100 text-gray-700">
                        <i class="fas fa-video mr-2"></i>
                        Video
                    </button>
                </div>

                <!-- Image Upload Section -->
                <div id="imageSection" class="tab-content">
                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <!-- Enhanced Upload Zone -->
                        <div class="upload-zone rounded-2xl p-12 text-center cursor-pointer" id="dropZone">
                            <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden" required>
                            
                            <div id="uploadPlaceholder">
                                <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full mx-auto mb-6 flex items-center justify-center shadow-lg">
                                    <i class="fas fa-cloud-upload-alt text-white text-3xl"></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Drag & Drop Foto Anda</h3>
                                <p class="text-gray-600 mb-4">atau klik untuk memilih file dari komputer</p>
                                <div class="flex items-center justify-center space-x-4 text-sm text-gray-500">
                                    <span><i class="fas fa-check-circle text-green-500 mr-1"></i>JPG, PNG, GIF</span>
                                    <span><i class="fas fa-check-circle text-green-500 mr-1"></i>Maksimal 5MB</span>
                                    <span><i class="fas fa-check-circle text-green-500 mr-1"></i>High Quality</span>
                                </div>
                                <button type="button" onclick="document.getElementById('gambar').click()" 
                                        class="mt-6 btn-primary text-white px-8 py-3 rounded-xl font-medium shadow-lg">
                                    <i class="fas fa-folder-open mr-2"></i>
                                    Pilih File
                                </button>
                            </div>
                            
                            <div id="previewContainer" class="hidden">
                                <img id="imagePreview" src="" alt="Preview" class="mx-auto max-h-80 rounded-xl shadow-lg mb-6">
                                <div class="flex items-center justify-center space-x-4">
                                    <button type="button" onclick="removeImage()" 
                                            class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors">
                                        <i class="fas fa-trash mr-2"></i>
                                        Hapus Gambar
                                    </button>
                                    <button type="button" onclick="document.getElementById('gambar').click()" 
                                            class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                        <i class="fas fa-exchange-alt mr-2"></i>
                                        Ganti Gambar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Form Fields Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Judul -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-heading mr-2 text-blue-500"></i>
                                    Judul Foto <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="judul" 
                                       name="judul" 
                                       value="{{ old('judul') }}"
                                       placeholder="Masukkan judul foto yang menarik..." 
                                       class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                            </div>

                            <!-- Kategori -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-tag mr-2 text-blue-500"></i>
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select id="kategori" 
                                        name="kategori" 
                                        class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>🎉 Kegiatan</option>
                                    <option value="masjid" {{ old('kategori') == 'masjid' ? 'selected' : '' }}>🕌 Masjid</option>
                                    <option value="kajian" {{ old('kategori') == 'kajian' ? 'selected' : '' }}>📚 Kajian</option>
                                    <option value="donasi" {{ old('kategori') == 'donasi' ? 'selected' : '' }}>💝 Donasi</option>
                                    <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>📌 Lainnya</option>
                                </select>
                            </div>

                            <!-- Tanggal -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar mr-2 text-blue-500"></i>
                                    Tanggal Foto
                                </label>
                                <input type="date" 
                                       id="tanggal" 
                                       name="tanggal" 
                                       value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                                       class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>

                            <!-- Lokasi -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                                    Lokasi
                                </label>
                                <input type="text" 
                                       id="lokasi" 
                                       name="lokasi" 
                                       value="{{ old('lokasi') }}"
                                       placeholder="Contoh: Masjid Al-Hasanah" 
                                       class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-blue-500"></i>
                                Deskripsi
                            </label>
                            <textarea id="deskripsi" 
                                      name="deskripsi" 
                                      rows="4"
                                      placeholder="Tambahkan deskripsi untuk memberikan konteks pada foto..."
                                      class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('deskripsi') }}</textarea>
                            <p class="text-sm text-gray-500 mt-2">Opsional: Tambahkan deskripsi untuk memberikan konteks pada foto</p>
                        </div>

                        <!-- Tags -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-hashtag mr-2 text-blue-500"></i>
                                Tags
                            </label>
                            <div class="flex flex-wrap gap-2 mb-3">
                                <span class="category-badge px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm cursor-pointer" onclick="toggleTag(this)">
                                    #kegiatan
                                </span>
                                <span class="category-badge px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm cursor-pointer" onclick="toggleTag(this)">
                                    #masjid
                                </span>
                                <span class="category-badge px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm cursor-pointer" onclick="toggleTag(this)">
                                    #kajian
                                </span>
                                <span class="category-badge px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-sm cursor-pointer" onclick="toggleTag(this)">
                                    #donasi
                                </span>
                                <span class="category-badge px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-sm cursor-pointer" onclick="toggleTag(this)">
                                    #community
                                </span>
                            </div>
                            <input type="text" 
                                   id="tags" 
                                   name="tags" 
                                   placeholder="Tambahkan tags custom (pisahkan dengan koma)" 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-eye mr-2 text-blue-500"></i>
                                Status Publikasi
                            </label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="published" {{ old('status', 'published') == 'published' ? 'checked' : '' }} class="mr-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-globe text-green-500 mr-2"></i>
                                        <span class="font-medium">Publikasikan</span>
                                    </div>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="status" value="draft" {{ old('status') == 'draft' ? 'checked' : '' }} class="mr-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-lock text-gray-500 mr-2"></i>
                                        <span class="font-medium">Draft</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                            <div class="flex items-center space-x-4">
                                <button type="button" onclick="saveDraft()" 
                                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-all">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan Draft
                                </button>
                                <button type="button" onclick="previewMedia()" 
                                        class="px-6 py-3 bg-purple-100 hover:bg-purple-200 text-purple-700 rounded-xl font-medium transition-all">
                                    <i class="fas fa-eye mr-2"></i>
                                    Preview
                                </button>
                            </div>
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.galeri.index') }}" 
                                   class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-all">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </a>
                                <button type="submit" 
                                        class="btn-primary text-white px-8 py-3 rounded-xl font-medium shadow-lg">
                                    <i class="fas fa-upload mr-2"></i>
                                    Upload Foto
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Video Upload Section -->
                <div id="videoSection" class="tab-content hidden">
                    <form action="{{ route('admin.galeri.store-video') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- YouTube URL Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fab fa-youtube mr-2 text-red-500"></i>
                                Link YouTube <span class="text-red-500">*</span>
                            </label>
                            <input type="url" 
                                   name="youtube_url" 
                                   placeholder="https://youtube.com/watch?v=..." 
                                   class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                   required>
                            <p class="text-sm text-gray-500 mt-2">Masukkan link video YouTube yang ingin ditambahkan</p>
                        </div>

                        <!-- Video Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-heading mr-2 text-red-500"></i>
                                    Judul Video <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="video_judul" 
                                       placeholder="Masukkan judul video..." 
                                       class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user-tie mr-2 text-red-500"></i>
                                    Ustadz
                                </label>
                                <input type="text" 
                                       name="ustadz" 
                                       placeholder="Nama ustadz..." 
                                       class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            </div>
                        </div>

                        <!-- Video Description -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-align-left mr-2 text-red-500"></i>
                                Deskripsi Video
                            </label>
                            <textarea name="video_deskripsi" 
                                      rows="4"
                                      placeholder="Tambahkan deskripsi video..."
                                      class="form-input w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent"></textarea>
                        </div>

                        <!-- Video Actions -->
                        <div class="flex items-center justify-between pt-8 border-t border-gray-200">
                            <a href="{{ route('admin.galeri.index') }}" 
                               class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition-all">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali
                            </a>
                            <button type="submit" 
                                    class="btn-primary text-white px-8 py-3 rounded-xl font-medium shadow-lg">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Video
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-8 max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-gray-900">Preview Media</h3>
                <button onclick="closePreviewModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="previewContent">
                <!-- Preview content will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        // Tab switching
        function switchTab(tab) {
            const imageTab = document.getElementById('imageTab');
            const videoTab = document.getElementById('videoTab');
            const imageSection = document.getElementById('imageSection');
            const videoSection = document.getElementById('videoSection');

            if (tab === 'image') {
                imageTab.classList.add('active');
                imageTab.classList.remove('bg-gray-100', 'text-gray-700');
                videoTab.classList.remove('active');
                videoTab.classList.add('bg-gray-100', 'text-gray-700');
                imageSection.classList.remove('hidden');
                videoSection.classList.add('hidden');
            } else {
                videoTab.classList.add('active');
                videoTab.classList.remove('bg-gray-100', 'text-gray-700');
                imageTab.classList.remove('active');
                imageTab.classList.add('bg-gray-100', 'text-gray-700');
                videoSection.classList.remove('hidden');
                imageSection.classList.add('hidden');
            }
        }

        // File upload handling
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('gambar');
        const previewContainer = document.getElementById('previewContainer');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const imagePreview = document.getElementById('imagePreview');

        // Click to upload
        dropZone.addEventListener('click', () => {
            fileInput.click();
        });

        // Drag and drop
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
                handleFileSelect(files[0]);
            }
        });

        // File selection
        fileInput.addEventListener('change', (e) => {
            if (e.target.files.length > 0) {
                handleFileSelect(e.target.files[0]);
            }
        });

        function handleFileSelect(file) {
            // Validate file type
            if (!file.type.startsWith('image/')) {
                showNotification('File harus berupa gambar (JPG, PNG, GIF)', 'error');
                return;
            }
            
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                showNotification('Ukuran file maksimal 5MB', 'error');
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                uploadPlaceholder.classList.add('hidden');
                previewContainer.classList.remove('hidden');
                showNotification('Gambar berhasil diunggah', 'success');
            };
            reader.readAsDataURL(file);
        }

        function removeImage() {
            fileInput.value = '';
            imagePreview.src = '';
            uploadPlaceholder.classList.remove('hidden');
            previewContainer.classList.add('hidden');
            showNotification('Gambar dihapus', 'info');
        }

        // Tag functionality
        function toggleTag(element) {
            element.classList.toggle('ring-2');
            element.classList.toggle('ring-blue-500');
            updateTagsInput();
        }

        function updateTagsInput() {
            const selectedTags = Array.from(document.querySelectorAll('.category-badge.ring-2'))
                .map(tag => tag.textContent.trim());
            document.getElementById('tags').value = selectedTags.join(', ');
        }

        // Preview functionality
        function previewMedia() {
            const previewContent = document.getElementById('previewContent');
            const judul = document.getElementById('judul').value;
            const deskripsi = document.getElementById('deskripsi').value;
            const kategori = document.getElementById('kategori').value;
            
            if (!imagePreview.src || imagePreview.src === '') {
                showNotification('Silakan unggah gambar terlebih dahulu', 'error');
                return;
            }

            previewContent.innerHTML = `
                <div class="space-y-6">
                    <img src="${imagePreview.src}" alt="Preview" class="w-full rounded-xl shadow-lg">
                    <div>
                        <h4 class="text-xl font-bold text-gray-900 mb-2">${judul || 'Tanpa Judul'}</h4>
                        <p class="text-gray-600 mb-4">${deskripsi || 'Tidak ada deskripsi'}</p>
                        <div class="flex items-center space-x-4">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                ${kategori || 'Tidak ada kategori'}
                            </span>
                            <span class="text-sm text-gray-500">
                                ${new Date().toLocaleDateString('id-ID')}
                            </span>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('previewModal').classList.remove('hidden');
        }

        function closePreviewModal() {
            document.getElementById('previewModal').classList.add('hidden');
        }

        // Save draft functionality
        function saveDraft() {
            const form = document.querySelector('form');
            const formData = new FormData(form);
            formData.set('action', 'save_draft');
            
            // Simulate draft save
            showNotification('Draft berhasil disimpan', 'success');
        }

        // Notification system
        function showNotification(message, type = 'info') {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                info: 'bg-blue-500',
                warning: 'bg-yellow-500'
            };

            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center space-x-2`;
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.opacity = '0';
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', (e) => {
            if (!fileInput.files.length) {
                e.preventDefault();
                showNotification('Silakan pilih foto terlebih dahulu', 'error');
                return;
            }
            
            const title = document.getElementById('judul').value.trim();
            if (!title) {
                e.preventDefault();
                showNotification('Judul foto harus diisi', 'error');
                return;
            }
            
            const category = document.getElementById('kategori').value;
            if (!category) {
                e.preventDefault();
                showNotification('Kategori harus dipilih', 'error');
                return;
            }
        });

        // Auto-save functionality
        let autoSaveTimer;
        document.querySelector('form').addEventListener('input', () => {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                saveDraft();
            }, 30000); // Auto-save after 30 seconds
        });
    </script>
</body>
</html>
