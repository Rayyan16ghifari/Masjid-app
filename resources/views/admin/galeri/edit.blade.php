@extends('layouts.admin')

@section('title', 'Edit Foto Galeri')

@section('page-title', 'Edit Foto Galeri')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Edit Foto Galeri</h1>
        <p class="text-gray-600 mt-1">Perbarui informasi foto dokumentasi</p>
    </div>

    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Current Image -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Foto Saat Ini
            </label>
            <div class="border border-gray-200 rounded-lg p-4">
                @if($galeri->gambar)
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('images/masjid/' . $galeri->gambar) }}" 
                             alt="{{ $galeri->judul ?? 'Galeri Foto' }}"
                             class="w-32 h-32 object-cover rounded-lg"
                             onerror="this.src='https://via.placeholder.com/128x128/e5e7eb/6b7280?text=No+Image'">
                        <div>
                            <p class="text-sm text-gray-600">File: {{ $galeri->gambar }}</p>
                            <p class="text-xs text-gray-500 mt-1">Diunggah: {{ $galeri->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-image text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-600">Belum ada foto</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- New Image Upload -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Ganti Foto <span class="text-gray-500">(Opsional)</span>
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors" id="dropZone">
                <input type="file" name="gambar" id="gambar" accept="image/*" class="hidden">
                
                <div id="previewContainer" class="hidden">
                    <img id="imagePreview" src="" alt="Preview" class="mx-auto max-h-64 rounded-lg mb-4">
                    <button type="button" onclick="removeImage()" class="text-red-600 hover:text-red-700 text-sm">
                        <i class="fas fa-trash mr-1"></i>
                        Hapus Gambar Baru
                    </button>
                </div>
                
                <div id="uploadPlaceholder">
                    <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600 mb-2">Drag & drop foto baru di sini atau klik untuk memilih</p>
                    <p class="text-sm text-gray-500">Format: JPG, PNG, GIF. Maksimal: 5MB</p>
                    <button type="button" onclick="document.getElementById('gambar').click()" 
                            class="mt-4 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                        <i class="fas fa-folder-open mr-2"></i>
                        Pilih File Baru
                    </button>
                </div>
            </div>
            @error('gambar')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Judul -->
        <div>
            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                Judul Foto <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   id="judul" 
                   name="judul" 
                   value="{{ old('judul', $galeri->judul) }}"
                   placeholder="Masukkan judul foto..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                   required>
            @error('judul')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kategori -->
        <div>
            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-2">
                Kategori <span class="text-red-500">*</span>
            </label>
            <select id="kategori" 
                    name="kategori" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                    required>
                <option value="">Pilih Kategori</option>
                <option value="kegiatan" {{ old('kategori', $galeri->kategori) == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                <option value="masjid" {{ old('kategori', $galeri->kategori) == 'masjid' ? 'selected' : '' }}>Masjid</option>
                <option value="kajian" {{ old('kategori', $galeri->kategori) == 'kajian' ? 'selected' : '' }}>Kajian</option>
                <option value="donasi" {{ old('kategori', $galeri->kategori) == 'donasi' ? 'selected' : '' }}>Donasi</option>
                <option value="lainnya" {{ old('kategori', $galeri->kategori) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('kategori')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div>
            <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi
            </label>
            <textarea id="deskripsi" 
                      name="deskripsi" 
                      rows="4"
                      placeholder="Tambahkan deskripsi foto..."
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
            <p class="text-sm text-gray-500 mt-1">Opsional: Tambahkan deskripsi untuk memberikan konteks pada foto</p>
            @error('deskripsi')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tanggal -->
        <div>
            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                Tanggal Foto
            </label>
            <input type="date" 
                   id="tanggal" 
                   name="tanggal" 
                   value="{{ old('tanggal', $galeri->tanggal ?? $galeri->created_at->format('Y-m-d')) }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            <p class="text-sm text-gray-500 mt-1">Opsional: Tanggal saat foto diambil</p>
            @error('tanggal')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Status -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Status Publikasi
            </label>
            <div class="flex items-center space-x-6">
                <label class="flex items-center">
                    <input type="radio" name="status" value="published" {{ old('status', $galeri->status ?? 'published') == 'published' ? 'checked' : '' }} class="mr-2">
                    <span class="text-gray-700">Publikasikan</span>
                </label>
                <label class="flex items-center">
                    <input type="radio" name="status" value="draft" {{ old('status', $galeri->status) == 'draft' ? 'checked' : '' }} class="mr-2">
                    <span class="text-gray-700">Draft</span>
                </label>
            </div>
            <p class="text-sm text-gray-500 mt-1">Pilih apakah foto akan ditampilkan di galeri publik</p>
            @error('status')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Statistics -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Statistik Foto</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ rand(50, 500) }}</div>
                    <div class="text-xs text-gray-600">Dilihat</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ rand(5, 50) }}</div>
                    <div class="text-xs text-gray-600">Suka</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $galeri->created_at->diffForHumans() }}</div>
                    <div class="text-xs text-gray-600">Diunggah</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900">{{ $galeri->updated_at->diffForHumans() }}</div>
                    <div class="text-xs text-gray-600">Diperbarui</div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.galeri.index') }}" 
                   class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                <button type="button" 
                        onclick="if(confirm('Apakah Anda yakin ingin menghapus foto ini?')) window.location.href='{{ route('admin.galeri.destroy', $galeri->id) }}'"
                        class="px-4 py-2 text-red-700 bg-red-100 hover:bg-red-200 rounded-lg transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Hapus
                </button>
            </div>
            <div class="flex items-center space-x-3">
                <button type="submit" name="action" value="save_draft" 
                        class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Draft
                </button>
                <button type="submit" name="action" value="publish" 
                        class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-upload mr-2"></i>
                    Perbarui
                </button>
            </div>
        </div>
    </form>
</div>

<script>
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
    dropZone.classList.add('border-primary-500', 'bg-primary-50');
});

dropZone.addEventListener('dragleave', () => {
    dropZone.classList.remove('border-primary-500', 'bg-primary-50');
});

dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropZone.classList.remove('border-primary-500', 'bg-primary-50');
    
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
        alert('File harus berupa gambar (JPG, PNG, GIF)');
        return;
    }
    
    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file maksimal 5MB');
        return;
    }
    
    // Show preview
    const reader = new FileReader();
    reader.onload = (e) => {
        imagePreview.src = e.target.result;
        uploadPlaceholder.classList.add('hidden');
        previewContainer.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function removeImage() {
    fileInput.value = '';
    imagePreview.src = '';
    uploadPlaceholder.classList.remove('hidden');
    previewContainer.classList.add('hidden');
}

// Auto-save functionality
let autoSaveTimer;
const form = document.querySelector('form');

form.addEventListener('input', () => {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
        // Show auto-save indicator
        const indicator = document.createElement('div');
        indicator.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        indicator.innerHTML = '<i class="fas fa-save mr-2"></i>Menyimpan draft...';
        document.body.appendChild(indicator);
        
        // Create FormData for auto-save
        const formData = new FormData(form);
        formData.set('action', 'auto_save');
        formData.set('_method', 'PUT');
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        }).then(response => {
            if (response.ok) {
                indicator.innerHTML = '<i class="fas fa-check mr-2"></i>Draft tersimpan';
                indicator.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                setTimeout(() => {
                    indicator.remove();
                }, 2000);
            } else {
                indicator.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Gagal menyimpan';
                indicator.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                setTimeout(() => {
                    indicator.remove();
                }, 2000);
            }
        });
    }, 30000); // Auto-save after 30 seconds of inactivity
});

// Form validation before submit
form.addEventListener('submit', (e) => {
    const title = document.getElementById('judul').value.trim();
    if (!title) {
        e.preventDefault();
        alert('Judul foto harus diisi');
        return;
    }
    
    const category = document.getElementById('kategori').value;
    if (!category) {
        e.preventDefault();
        alert('Kategori harus dipilih');
        return;
    }
    
    // Confirm if changing published status
    const currentStatus = '{{ $galeri->status ?? 'published' }}';
    const newStatus = document.querySelector('input[name="status"]:checked').value;
    
    if (currentStatus === 'published' && newStatus === 'draft') {
        if (!confirm('Mengubah status ke draft akan menyembunyikan foto dari galeri publik. Lanjutkan?')) {
            e.preventDefault();
        }
    }
});
</script>
@endsection
