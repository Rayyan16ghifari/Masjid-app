@extends('layouts.admin')

@section('title', 'Manajemen Galeri')

@section('page-title', 'Manajemen Galeri')

@section('content')
<!-- Header -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Manajemen Galeri</h1>
            <p class="text-gray-600 mt-1">Kelola foto-foto dokumentasi kegiatan masjid</p>
        </div>
        <a href="{{ route('admin.galeri.create') }}" 
           class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors">
            <i class="fas fa-plus"></i>
            <span>Tambah Foto</span>
        </a>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Cari Foto</label>
            <div class="relative">
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari berdasarkan judul atau deskripsi..." 
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter Kategori</label>
            <select id="categoryFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <option value="">Semua Kategori</option>
                <option value="kegiatan">Kegiatan</option>
                <option value="masjid">Masjid</option>
                <option value="kajian">Kajian</option>
                <option value="donasi">Donasi</option>
                <option value="lainnya">Lainnya</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan</label>
            <select id="sortFilter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <option value="newest">Terbaru</option>
                <option value="oldest">Terlama</option>
                <option value="title">Judul (A-Z)</option>
                <option value="category">Kategori</option>
            </select>
        </div>
    </div>
</div>

<!-- Gallery Grid -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">
            Daftar Foto 
            <span class="text-sm text-gray-600 ml-2">({{ $galeri->count() }} foto)</span>
        </h2>
        <div class="flex items-center space-x-2">
            <button id="gridView" class="p-2 text-primary-600 bg-primary-50 rounded-lg">
                <i class="fas fa-th"></i>
            </button>
            <button id="listView" class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                <i class="fas fa-list"></i>
            </button>
        </div>
    </div>
    
    <div id="galleryContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @if($galeri->count() > 0)
            @foreach($galeri as $item)
                <div class="gallery-item group relative bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-all duration-300" 
                     data-title="{{ strtolower($item->judul ?? '') }}" 
                     data-category="{{ $item->kategori ?? 'lainnya' }}"
                     data-date="{{ $item->created_at->timestamp }}">
                    
                    <!-- Image Container -->
                    <div class="relative aspect-square overflow-hidden bg-gray-100">
                        @if($item->gambar)
                            <img src="{{ asset('images/masjid/' . $item->gambar) }}" 
                                 alt="{{ $item->judul ?? 'Galeri Foto' }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.src='https://via.placeholder.com/400x400/e5e7eb/6b7280?text=No+Image'">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        
                        <!-- Overlay Actions -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                            <div class="flex space-x-2">
                                <button onclick="viewImage('{{ asset('images/masjid/' . $item->gambar) }}', '{{ $item->judul ?? 'Galeri Foto' }}')" 
                                        class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-eye text-gray-700"></i>
                                </button>
                                <a href="{{ route('admin.galeri.edit', $item->id) }}" 
                                   class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-edit text-blue-600"></i>
                                </a>
                                <button onclick="confirmDelete({{ $item->id }})" 
                                        class="p-2 bg-white rounded-full hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-trash text-red-600"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Category Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="px-2 py-1 bg-white bg-opacity-90 text-xs font-medium rounded-full">
                                {{ ucfirst($item->kategori ?? 'Lainnya') }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Info -->
                    <div class="p-4">
                        <h3 class="font-medium text-gray-900 truncate">{{ $item->judul ?? 'Tanpa Judul' }}</h3>
                        <p class="text-sm text-gray-600 truncate mt-1">{{ $item->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ $item->created_at->format('d M Y') }}
                            </span>
                            <span class="text-xs text-gray-500">
                                <i class="fas fa-eye mr-1"></i>
                                {{ rand(10, 100) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-full text-center py-12">
                <i class="fas fa-images text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Foto</h3>
                <p class="text-gray-600 mb-4">Mulai dengan menambahkan foto pertama ke galeri</p>
                <a href="{{ route('admin.galeri.create') }}" 
                   class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg inline-flex items-center space-x-2 transition-colors">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Foto Pertama</span>
                </a>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if($galeri->hasPages())
        <div class="mt-8">
            {{ $galeri->links() }}
        </div>
    @endif
</div>

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300">
            <i class="fas fa-times text-2xl"></i>
        </button>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full rounded-lg">
        <div id="modalCaption" class="text-white text-center mt-4"></div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900">Hapus Foto</h3>
                <p class="text-gray-600">Apakah Anda yakin ingin menghapus foto ini? Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" 
                        class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', filterGallery);
document.getElementById('categoryFilter').addEventListener('change', filterGallery);
document.getElementById('sortFilter').addEventListener('change', filterGallery);

function filterGallery() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const categoryFilter = document.getElementById('categoryFilter').value;
    const sortBy = document.getElementById('sortFilter').value;
    
    const items = document.querySelectorAll('.gallery-item');
    const container = document.getElementById('galleryContainer');
    
    // Filter items
    const filteredItems = Array.from(items).filter(item => {
        const title = item.dataset.title;
        const category = item.dataset.category;
        
        const matchesSearch = title.includes(searchTerm);
        const matchesCategory = !categoryFilter || category === categoryFilter;
        
        return matchesSearch && matchesCategory;
    });
    
    // Sort items
    filteredItems.sort((a, b) => {
        switch(sortBy) {
            case 'newest':
                return parseInt(b.dataset.date) - parseInt(a.dataset.date);
            case 'oldest':
                return parseInt(a.dataset.date) - parseInt(b.dataset.date);
            case 'title':
                return a.dataset.title.localeCompare(b.dataset.title);
            case 'category':
                return a.dataset.category.localeCompare(b.dataset.category);
            default:
                return 0;
        }
    });
    
    // Reorder DOM
    filteredItems.forEach(item => container.appendChild(item));
    
    // Show/hide items
    items.forEach(item => {
        item.style.display = filteredItems.includes(item) ? 'block' : 'none';
    });
}

// View image modal
function viewImage(src, caption) {
    document.getElementById('modalImage').src = src;
    document.getElementById('modalCaption').textContent = caption;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Delete confirmation
function confirmDelete(id) {
    document.getElementById('deleteForm').action = `/admin/galeri/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// View toggle
document.getElementById('gridView').addEventListener('click', function() {
    document.getElementById('galleryContainer').className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6';
    this.classList.add('text-primary-600', 'bg-primary-50');
    this.classList.remove('text-gray-600', 'hover:bg-gray-100');
    document.getElementById('listView').classList.remove('text-primary-600', 'bg-primary-50');
    document.getElementById('listView').classList.add('text-gray-600', 'hover:bg-gray-100');
});

document.getElementById('listView').addEventListener('click', function() {
    document.getElementById('galleryContainer').className = 'space-y-4';
    this.classList.add('text-primary-600', 'bg-primary-50');
    this.classList.remove('text-gray-600', 'hover:bg-gray-100');
    document.getElementById('gridView').classList.remove('text-primary-600', 'bg-primary-50');
    document.getElementById('gridView').classList.add('text-gray-600', 'hover:bg-gray-100');
});

// Close modals on escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
        closeDeleteModal();
    }
});
</script>
@endsection
