<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Galeri</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Manajemen Galeri</h1>
                        <p class="text-gray-600 mt-1">Kelola foto dan video dokumentasi masjid</p>
                    </div>
                    <a href="{{ route('admin.galeri.create') }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Foto
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Foto</p>
                            <p class="text-2xl font-bold text-gray-900">{{ count($images) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-images text-blue-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Video</p>
                            <p class="text-2xl font-bold text-gray-900">{{ count($videos) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-video text-red-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Media</p>
                            <p class="text-2xl font-bold text-gray-900">{{ count($images) + count($videos) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-photo-video text-green-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gallery Grid -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Foto Galeri</h2>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <i class="fas fa-filter mr-1"></i>
                            Filter
                        </button>
                        <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <i class="fas fa-sort mr-1"></i>
                            Urutkan
                        </button>
                    </div>
                </div>
                
                @if(count($images) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($images as $image)
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                                    <img src="{{ asset('images/gallery/' . $image['name']) }}" 
                                         alt="{{ $image['name'] ?? 'Gallery Image' }}"
                                         class="w-full h-48 object-cover"
                                         onerror="this.src='https://via.placeholder.com/400x300/e5e7eb/6b7280?text=No+Image'">
                                </div>
                                <div class="p-4">
                                    <h3 class="font-medium text-gray-900 truncate">{{ $image['name'] ?? 'Untitled' }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ number_format(($image['size'] ?? 0) / 1024, 2) }} KB</p>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs text-gray-400">
                                            {{ $image['modified'] ? date('d M Y', $image['modified']) : 'N/A' }}
                                        </span>
                                        <div class="flex items-center space-x-1">
                                            <button class="p-1 text-blue-600 hover:bg-blue-50 rounded">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>
                                            <button class="p-1 text-red-600 hover:bg-red-50 rounded">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-images text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Foto</h3>
                        <p class="text-gray-600 mb-4">Mulai dengan menambahkan foto pertama ke galeri</p>
                        <a href="{{ route('admin.galeri.create') }}" 
                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg inline-flex items-center space-x-2 transition-colors">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Foto Pertama</span>
                        </a>
                    </div>
                @endif
            </div>

            <!-- Video Section -->
            @if(count($videos) > 0)
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Video Gallery</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($videos as $video)
                            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                <div class="aspect-w-16 aspect-h-9 bg-gray-100">
                                    @if($video->thumbnail)
                                        <img src="{{ asset('storage/' . $video->thumbnail) }}" 
                                             alt="{{ $video->judul }}"
                                             class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-play-circle text-gray-400 text-4xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-medium text-gray-900 truncate">{{ $video->judul }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $video->ustadz }}</p>
                                    <div class="flex items-center justify-between mt-3">
                                        <span class="text-xs text-gray-400">
                                            {{ $video->created_at ? $video->created_at->format('d M Y') : 'N/A' }}
                                        </span>
                                        <div class="flex items-center space-x-1">
                                            <a href="{{ $video->youtube_url }}" target="_blank" 
                                               class="p-1 text-blue-600 hover:bg-blue-50 rounded">
                                                <i class="fas fa-external-link-alt text-sm"></i>
                                            </a>
                                            <button class="p-1 text-red-600 hover:bg-red-50 rounded">
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
