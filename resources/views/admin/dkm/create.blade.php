@extends('layouts.admin')

@section('title', 'Tambah Anggota DKM')

@section('page-title', 'Tambah Anggota DKM')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Tambah Anggota DKM</h1>
        <p class="text-gray-600 mt-1">Tambahkan anggota baru ke Dewan Kemakmuran Masjid</p>
    </div>

    <form action="{{ route('admin.dkm.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Personal Information -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pribadi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Foto -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Profil <span class="text-gray-500">(Opsional)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors" id="dropZone">
                        <input type="file" name="foto" id="foto" accept="image/*" class="hidden">
                        
                        <div id="previewContainer" class="hidden">
                            <img id="imagePreview" src="" alt="Preview" class="mx-auto w-32 h-32 rounded-full object-cover mb-4">
                            <button type="button" onclick="removeImage()" class="text-red-600 hover:text-red-700 text-sm">
                                <i class="fas fa-trash mr-1"></i>
                                Hapus Foto
                            </button>
                        </div>
                        
                        <div id="uploadPlaceholder">
                            <i class="fas fa-user-circle text-6xl text-gray-400 mb-4"></i>
                            <p class="text-gray-600 mb-2">Klik untuk upload foto profil</p>
                            <p class="text-sm text-gray-500">Format: JPG, PNG. Maksimal: 2MB</p>
                            <button type="button" onclick="document.getElementById('foto').click()" 
                                    class="mt-4 px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors">
                                <i class="fas fa-camera mr-2"></i>
                                Pilih Foto
                            </button>
                        </div>
                    </div>
                    @error('foto')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Lengkap -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama" 
                           name="nama" 
                           value="{{ old('nama') }}"
                           placeholder="Masukkan nama lengkap..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           required>
                    @error('nama')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jabatan -->
                <div>
                    <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Jabatan <span class="text-red-500">*</span>
                    </label>
                    <select id="jabatan" 
                            name="jabatan" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                            required>
                        <option value="">Pilih Jabatan</option>
                        <option value="Ketua" {{ old('jabatan') == 'Ketua' ? 'selected' : '' }}>Ketua</option>
                        <option value="Wakil Ketua" {{ old('jabatan') == 'Wakil Ketua' ? 'selected' : '' }}>Wakil Ketua</option>
                        <option value="Sekretaris" {{ old('jabatan') == 'Sekretaris' ? 'selected' : '' }}>Sekretaris</option>
                        <option value="Bendahara" {{ old('jabatan') == 'Bendahara' ? 'selected' : '' }}>Bendahara</option>
                        <option value="Anggota" {{ old('jabatan') == 'Anggota' ? 'selected' : '' }}>Anggota</option>
                    </select>
                    @error('jabatan')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-gray-500">(Opsional)</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email') }}"
                           placeholder="email@example.com" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('email')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No. HP -->
                <div>
                    <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                        No. HP <span class="text-gray-500">(Opsional)</span>
                    </label>
                    <input type="tel" 
                           id="no_hp" 
                           name="no_hp" 
                           value="{{ old('no_hp') }}"
                           placeholder="08123456789" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('no_hp')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Address Information -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Alamat</h3>
            
            <div class="space-y-4">
                <!-- Alamat Lengkap -->
                <div>
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-gray-500">(Opsional)</span>
                    </label>
                    <textarea id="alamat" 
                              name="alamat" 
                              rows="3"
                              placeholder="Masukkan alamat lengkap..."
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- RT/RW -->
                    <div>
                        <label for="rt_rw" class="block text-sm font-medium text-gray-700 mb-2">
                            RT/RW <span class="text-gray-500">(Opsional)</span>
                        </label>
                        <input type="text" 
                               id="rt_rw" 
                               name="rt_rw" 
                               value="{{ old('rt_rw') }}"
                               placeholder="001/002" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        @error('rt_rw')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kelurahan -->
                    <div>
                        <label for="kelurahan" class="block text-sm font-medium text-gray-700 mb-2">
                            Kelurahan <span class="text-gray-500">(Opsional)</span>
                        </label>
                        <input type="text" 
                               id="kelurahan" 
                               name="kelurahan" 
                               value="{{ old('kelurahan') }}"
                               placeholder="Nama kelurahan" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        @error('kelurahan')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kecamatan -->
                    <div>
                        <label for="kecamatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Kecamatan <span class="text-gray-500">(Opsional)</span>
                        </label>
                        <input type="text" 
                               id="kecamatan" 
                               name="kecamatan" 
                               value="{{ old('kecamatan') }}"
                               placeholder="Nama kecamatan" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        @error('kecamatan')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="border-t border-gray-200 pt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Tambahan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Masa Jabatan -->
                <div>
                    <label for="masa_jabatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Masa Jabatan <span class="text-gray-500">(Opsional)</span>
                    </label>
                    <input type="text" 
                           id="masa_jabatan" 
                           name="masa_jabatan" 
                           value="{{ old('masa_jabatan') }}"
                           placeholder="2024-2027" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    @error('masa_jabatan')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status Keanggotaan
                    </label>
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center">
                            <input type="radio" name="status" value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'checked' : '' }} class="mr-2">
                            <span class="text-gray-700">Aktif</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="status" value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'checked' : '' }} class="mr-2">
                            <span class="text-gray-700">Tidak Aktif</span>
                        </label>
                    </div>
                    @error('status')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                    Keterangan <span class="text-gray-500">(Opsional)</span>
                </label>
                <textarea id="keterangan" 
                          name="keterangan" 
                          rows="3"
                          placeholder="Tambahkan keterangan tambahan..."
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
            <a href="{{ route('admin.dkm.index') }}" 
               class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
            <div class="flex items-center space-x-3">
                <button type="submit" name="action" value="save_draft" 
                        class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Simpan Draft
                </button>
                <button type="submit" name="action" value="save" 
                        class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-user-plus mr-2"></i>
                    Tambah Anggota
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// File upload handling
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('foto');
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
        alert('File harus berupa gambar (JPG, PNG)');
        return;
    }
    
    // Validate file size (2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file maksimal 2MB');
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

// Phone number formatting
document.getElementById('no_hp').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.startsWith('0')) {
        value = value.substring(0, 13);
    } else {
        value = value.substring(0, 12);
    }
    e.target.value = value;
});

// Form validation before submit
const form = document.querySelector('form');
form.addEventListener('submit', (e) => {
    const nama = document.getElementById('nama').value.trim();
    if (!nama) {
        e.preventDefault();
        alert('Nama lengkap harus diisi');
        return;
    }
    
    const jabatan = document.getElementById('jabatan').value;
    if (!jabatan) {
        e.preventDefault();
        alert('Jabatan harus dipilih');
        return;
    }
    
    // Validate email format if provided
    const email = document.getElementById('email').value.trim();
    if (email && !isValidEmail(email)) {
        e.preventDefault();
        alert('Format email tidak valid');
        return;
    }
});

function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// Auto-save functionality
let autoSaveTimer;
form.addEventListener('input', () => {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
        if (confirm('Auto-save draft?')) {
            // Create FormData for auto-save
            const formData = new FormData(form);
            formData.set('action', 'auto_save');
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            }).then(response => {
                if (response.ok) {
                    console.log('Draft auto-saved');
                }
            });
        }
    }, 30000); // Auto-save after 30 seconds of inactivity
});
</script>
@endsection
