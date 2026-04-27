<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Galeri - Admin Panel</title>
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
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        .stats-card {
            background: linear-gradient(135deg, var(--tw-gradient-from), var(--tw-gradient-to));
            transition: all 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.2);
        }
        .image-overlay {
            background: linear-gradient(to bottom, transparent 0%, rgba(0,0,0,0.7) 100%);
        }
        .checkbox-custom {
            appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #e5e7eb;
            border-radius: 4px;
            transition: all 0.2s;
        }
        .checkbox-custom:checked {
            background: #3b82f6;
            border-color: #3b82f6;
        }
        .checkbox-custom:checked::after {
            content: '✓';
            color: white;
            display: block;
            text-align: center;
            line-height: 16px;
        }
        .search-input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            transition: all 0.3s ease;
        }
        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563, #374151);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen">
    <!-- Background Pattern -->
    <div class="fixed inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <div class="relative z-10 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="glass-effect rounded-2xl shadow-2xl p-8 mb-8 slide-in">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-images text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-900 to-gray-600 bg-clip-text text-transparent">
                                Manajemen Galeri
                            </h1>
                            <p class="text-gray-600 mt-1">Kelola foto dan video dokumentasi masjid dengan mudah</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="bulkUpload()" class="btn-secondary text-white px-6 py-3 rounded-xl font-medium shadow-lg">
                            <i class="fas fa-cloud-upload-alt mr-2"></i>
                            Upload Bulk
                        </button>
                        <a href="{{ route('admin.galeri.create') }}" 
                           class="btn-primary text-white px-6 py-3 rounded-xl font-medium shadow-lg">
                            <i class="fas fa-plus mr-2"></i>
                            Tambah Media
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enhanced Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="stats-card --tw-gradient-from:blue-500 --tw-gradient-to:blue-600 rounded-2xl p-6 text-white shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium mb-1">Total Foto</p>
                            <p class="text-3xl font-bold">{{ count($images) }}</p>
                            <p class="text-blue-100 text-xs mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +12% dari bulan lalu
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-images text-2xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stats-card --tw-gradient-from:purple-500 --tw-gradient-to:purple-600 rounded-2xl p-6 text-white shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-medium mb-1">Total Video</p>
                            <p class="text-3xl font-bold">{{ count($videos) }}</p>
                            <p class="text-purple-100 text-xs mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +8% dari bulan lalu
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-video text-2xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stats-card --tw-gradient-from:emerald-500 --tw-gradient-to:emerald-600 rounded-2xl p-6 text-white shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-emerald-100 text-sm font-medium mb-1">Total Media</p>
                            <p class="text-3xl font-bold">{{ count($images) + count($videos) }}</p>
                            <p class="text-emerald-100 text-xs mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                +15% dari bulan lalu
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-photo-video text-2xl"></i>
                        </div>
                    </div>
                </div>
                
                <div class="stats-card --tw-gradient-from:orange-500 --tw-gradient-to:orange-600 rounded-2xl p-6 text-white shadow-xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-medium mb-1">Storage</p>
                            <p class="text-3xl font-bold">2.4 GB</p>
                            <p class="text-orange-100 text-xs mt-2">
                                <i class="fas fa-database mr-1"></i>
                                60% terpakai
                            </p>
                        </div>
                        <div class="w-14 h-14 bg-white/20 rounded-xl flex items-center justify-center">
                            <i class="fas fa-server text-2xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Search and Filter Section -->
            <div class="glass-effect rounded-2xl shadow-xl p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="relative">
                        <input type="text" 
                               placeholder="Cari media..." 
                               class="search-input w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <i class="fas fa-search absolute left-4 top-4 text-gray-400"></i>
                    </div>
                    
                    <select class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Tipe</option>
                        <option value="image">Foto</option>
                        <option value="video">Video</option>
                    </select>
                    
                    <select class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Semua Kategori</option>
                        <option value="kegiatan">Kegiatan</option>
                        <option value="masjid">Masjid</option>
                        <option value="kajian">Kajian</option>
                        <option value="donasi">Donasi</option>
                    </select>
                    
                    <div class="flex items-center space-x-2">
                        <button class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                            <i class="fas fa-filter mr-2"></i>
                            Filter
                        </button>
                        <button class="px-4 py-3 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">
                            <i class="fas fa-sort-amount-down"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bulk Actions Bar -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-4">
                    <input type="checkbox" id="selectAll" class="checkbox-custom">
                    <label for="selectAll" class="text-gray-700 font-medium">Pilih Semua</label>
                    <span class="text-sm text-gray-500">
                        <span id="selectedCount">0</span> item dipilih
                    </span>
                </div>
                <div class="flex items-center space-x-2 opacity-0" id="bulkActions">
                    <button class="px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                        <i class="fas fa-edit mr-2"></i>Edit Bulk
                    </button>
                    <button class="px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors">
                        <i class="fas fa-tag mr-2"></i>Kategori
                    </button>
                    <button onclick="bulkDelete()" class="px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </div>
            </div>

            <!-- Enhanced Gallery Grid -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Koleksi Media</h2>
                    <div class="flex items-center space-x-2">
                        <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <i class="fas fa-th-large"></i>
                        </button>
                        <button class="p-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>
                
                @if(count($images) > 0 || count($videos) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <!-- Image Cards -->
                        @foreach($images as $image)
                            <div class="card-hover bg-white rounded-xl overflow-hidden shadow-lg border border-gray-100">
                                <div class="relative group">
                                    <img src="{{ asset('images/gallery/' . $image['name']) }}" 
                                         alt="{{ $image['name'] ?? 'Gallery Image' }}"
                                         class="w-full h-64 object-cover"
                                         onerror="this.src='https://picsum.photos/seed/gallery/400/300.jpg'">
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="flex items-center space-x-2">
                                                <button class="p-3 bg-white/90 hover:bg-white rounded-full shadow-lg transition-all">
                                                    <i class="fas fa-eye text-gray-700"></i>
                                                </button>
                                                <button class="p-3 bg-white/90 hover:bg-white rounded-full shadow-lg transition-all">
                                                    <i class="fas fa-edit text-blue-600"></i>
                                                </button>
                                                <button class="p-3 bg-white/90 hover:bg-white rounded-full shadow-lg transition-all">
                                                    <i class="fas fa-download text-green-600"></i>
                                                </button>
                                                <button class="p-3 bg-white/90 hover:bg-white rounded-full shadow-lg transition-all">
                                                    <i class="fas fa-trash text-red-600"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Checkbox -->
                                    <div class="absolute top-3 left-3">
                                        <input type="checkbox" class="checkbox-custom" data-id="{{ $image['name'] }}">
                                    </div>
                                    
                                    <!-- Type Badge -->
                                    <div class="absolute top-3 right-3">
                                        <span class="px-2 py-1 bg-blue-500 text-white text-xs rounded-full">
                                            Foto
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 truncate mb-2">{{ $image['name'] ?? 'Untitled' }}</h3>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>{{ number_format(($image['size'] ?? 0) / 1024, 2) }} MB</span>
                                        <span>{{ $image['modified'] ? date('d M Y', $image['modified']) : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Video Cards -->
                        @foreach($videos as $video)
                            <div class="card-hover bg-white rounded-xl overflow-hidden shadow-lg border border-gray-100">
                                <div class="relative group">
                                    @if($video->thumbnail)
                                        <img src="{{ asset('storage/' . $video->thumbnail) }}" 
                                             alt="{{ $video->judul }}"
                                             class="w-full h-64 object-cover">
                                    @else
                                        <div class="w-full h-64 bg-gradient-to-br from-red-500 to-pink-500 flex items-center justify-center">
                                            <i class="fas fa-play-circle text-white text-6xl"></i>
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 image-overlay opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="flex items-center space-x-2">
                                                <button class="p-3 bg-white/90 hover:bg-white rounded-full shadow-lg transition-all">
                                                    <i class="fas fa-play text-gray-700"></i>
                                                </button>
                                                <button class="p-3 bg-white/90 hover:bg-white rounded-full shadow-lg transition-all">
                                                    <i class="fas fa-edit text-blue-600"></i>
                                                </button>
                                                <button class="p-3 bg-white/90 hover:bg-white rounded-full shadow-lg transition-all">
                                                    <i class="fas fa-external-link-alt text-green-600"></i>
                                                </button>
                                                <button class="p-3 bg-white/90 hover:bg-white rounded-full shadow-lg transition-all">
                                                    <i class="fas fa-trash text-red-600"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Checkbox -->
                                    <div class="absolute top-3 left-3">
                                        <input type="checkbox" class="checkbox-custom" data-id="{{ $video->id }}">
                                    </div>
                                    
                                    <!-- Type Badge -->
                                    <div class="absolute top-3 right-3">
                                        <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full">
                                            Video
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 truncate mb-2">{{ $video->judul }}</h3>
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>{{ $video->ustadz ?? 'N/A' }}</span>
                                        <span>{{ $video->created_at ? $video->created_at->format('d M Y') : 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <div class="w-32 h-32 bg-gray-100 rounded-full mx-auto mb-6 flex items-center justify-center">
                            <i class="fas fa-images text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Media</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Mulai dengan menambahkan foto atau video pertama ke galeri masjid
                        </p>
                        <a href="{{ route('admin.galeri.create') }}" 
                           class="btn-primary text-white px-8 py-3 rounded-xl font-medium shadow-lg inline-flex items-center space-x-2">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Media Pertama</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bulk Upload Modal -->
    <div id="bulkUploadModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-8 max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <h3 class="text-2xl font-bold text-gray-900 mb-6">Upload Multiple Media</h3>
            
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors mb-6">
                <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-4"></i>
                <p class="text-gray-600 mb-2">Drag & drop files here or click to browse</p>
                <p class="text-sm text-gray-500">Support: JPG, PNG, GIF, MP4 (Max 10MB per file)</p>
                <input type="file" multiple accept="image/*,video/*" class="hidden" id="bulkFileInput">
                <button onclick="document.getElementById('bulkFileInput').click()" 
                        class="mt-4 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors">
                    Choose Files
                </button>
            </div>
            
            <div class="flex justify-end space-x-3">
                <button onclick="closeBulkUploadModal()" 
                        class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl transition-colors">
                    Cancel
                </button>
                <button onclick="processBulkUpload()" 
                        class="btn-primary text-white px-6 py-3 rounded-xl">
                    Upload All
                </button>
            </div>
        </div>
    </div>

    <script>
        // Select All functionality
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.checkbox-custom');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateBulkActions();
        });

        // Individual checkbox functionality
        document.querySelectorAll('.checkbox-custom').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkActions);
        });

        function updateBulkActions() {
            const checkedBoxes = document.querySelectorAll('.checkbox-custom:checked');
            const count = checkedBoxes.length;
            document.getElementById('selectedCount').textContent = count;
            
            const bulkActions = document.getElementById('bulkActions');
            if (count > 0) {
                bulkActions.classList.remove('opacity-0');
                bulkActions.classList.add('opacity-100');
            } else {
                bulkActions.classList.add('opacity-0');
                bulkActions.classList.remove('opacity-100');
            }
        }

        // Bulk Upload
        function bulkUpload() {
            document.getElementById('bulkUploadModal').classList.remove('hidden');
        }

        function closeBulkUploadModal() {
            document.getElementById('bulkUploadModal').classList.add('hidden');
        }

        function processBulkUpload() {
            // Implementation for bulk upload
            alert('Bulk upload functionality will be implemented');
            closeBulkUploadModal();
        }

        // Bulk Delete
        function bulkDelete() {
            const checkedBoxes = document.querySelectorAll('.checkbox-custom:checked');
            if (checkedBoxes.length === 0) {
                alert('Please select items to delete');
                return;
            }
            
            if (confirm(`Are you sure you want to delete ${checkedBoxes.length} items?`)) {
                // Implementation for bulk delete
                alert('Bulk delete functionality will be implemented');
            }
        }

        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            // Implement search logic here
            console.log('Searching for:', searchTerm);
        });

        // Filter functionality
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', function() {
                // Implement filter logic here
                console.log('Filter changed:', this.value);
            });
        });
    </script>
</body>
</html>
