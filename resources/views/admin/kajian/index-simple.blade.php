<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kajian</title>
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
                        <h1 class="text-2xl font-bold text-gray-900">Manajemen Kajian</h1>
                        <p class="text-gray-600 mt-1">Kelola jadwal dan konten kajian masjid</p>
                    </div>
                    <a href="{{ route('admin.kajian.create') }}" 
                       class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Kajian
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Kajian</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $kajians->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-book text-blue-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Kajian Aktif</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $kajians->where('status', 'aktif')->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Kajian Hari Ini</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $kajians->where('tanggal', now()->format('Y-m-d'))->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-day text-yellow-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Total Ustadz</p>
                            <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Ustadz::count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-user-tie text-purple-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cari Kajian</label>
                        <div class="relative">
                            <input type="text" 
                                   placeholder="Cari berdasarkan judul atau ustadz..." 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="tidak aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Ustadz</label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Semua Ustadz</option>
                            @foreach(\App\Models\Ustadz::orderBy('nama')->get() as $ustadz)
                                <option value="{{ $ustadz->id }}">{{ $ustadz->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Kajian List -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Daftar Kajian 
                        <span class="text-sm text-gray-600 ml-2">({{ $kajians->count() }} kajian)</span>
                    </h2>
                    <div class="flex items-center space-x-2">
                        <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <i class="fas fa-th-large mr-1"></i>
                            Grid
                        </button>
                        <button class="px-3 py-1 text-sm bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                            <i class="fas fa-list mr-1"></i>
                            List
                        </button>
                    </div>
                </div>
                
                @if($kajians->count() > 0)
                    <div class="space-y-4">
                        @foreach($kajians as $kajian)
                            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-lg transition-shadow">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <h3 class="text-lg font-semibold text-gray-900">{{ $kajian->judul }}</h3>
                                            <span class="px-2 py-1 text-xs rounded-full {{ $kajian->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                                {{ $kajian->status === 'aktif' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </div>
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600 mb-3">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-tie w-4 mr-2 text-gray-400"></i>
                                                <span>{{ $kajian->ustadz->nama ?? 'Tidak ada ustadz' }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-calendar w-4 mr-2 text-gray-400"></i>
                                                <span>{{ \Carbon\Carbon::parse($kajian->tanggal)->format('d M Y') }}</span>
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-clock w-4 mr-2 text-gray-400"></i>
                                                <span>{{ $kajian->waktu }}</span>
                                            </div>
                                        </div>
                                        
                                        @if($kajian->lokasi)
                                            <div class="flex items-center text-sm text-gray-600 mb-3">
                                                <i class="fas fa-map-marker-alt w-4 mr-2 text-gray-400"></i>
                                                <span>{{ $kajian->lokasi }}</span>
                                            </div>
                                        @endif
                                        
                                        @if($kajian->deskripsi)
                                            <p class="text-gray-700 text-sm mb-3 line-clamp-2">{{ $kajian->deskripsi }}</p>
                                        @endif
                                        
                                        @if($kajian->link_youtube || $kajian->link_streaming)
                                            <div class="flex items-center space-x-4 text-sm">
                                                @if($kajian->link_youtube)
                                                    <a href="{{ $kajian->link_youtube }}" target="_blank" 
                                                       class="flex items-center text-red-600 hover:text-red-700">
                                                        <i class="fab fa-youtube mr-1"></i>
                                                        YouTube
                                                    </a>
                                                @endif
                                                @if($kajian->link_streaming)
                                                    <a href="{{ $kajian->link_streaming }}" target="_blank" 
                                                       class="flex items-center text-blue-600 hover:text-blue-700">
                                                        <i class="fas fa-video mr-1"></i>
                                                        Streaming
                                                    </a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center space-x-2 ml-4">
                                        <a href="{{ route('admin.kajian.edit', $kajian->id) }}" 
                                           class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button onclick="confirmDelete({{ $kajian->id }}, '{{ $kajian->judul }}')" 
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $kajians->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-book text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Kajian</h3>
                        <p class="text-gray-600 mb-4">Mulai dengan menambahkan kajian pertama</p>
                        <a href="{{ route('admin.kajian.create') }}" 
                           class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg inline-flex items-center space-x-2 transition-colors">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Kajian Pertama</span>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(id, title) {
        if (confirm(`Apakah Anda yakin ingin menghapus kajian "${title}"?`)) {
            // Create form for deletion
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/kajian/${id}`;
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="_method" value="DELETE">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
    </script>
</body>
</html>
