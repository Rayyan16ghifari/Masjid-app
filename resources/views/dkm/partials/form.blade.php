@php
    $member = $d ?? null;
    $formMode = $formMode ?? 'create';
    $formTitle = $formTitle ?? ($formMode === 'edit' ? 'Edit Anggota DKM' : 'Tambah Anggota DKM');
    $formSubtitle = $formSubtitle ?? 'Lengkapi data pengurus dengan struktur bidang yang rapi agar tampilan DKM tetap profesional.';
    $submitLabel = $submitLabel ?? ($formMode === 'edit' ? 'Simpan Perubahan' : 'Simpan Anggota');
    $cancelUrl = $cancelUrl ?? route('dkm.index');
@endphp

<style>
.dkm-form-page {
    min-height: 100vh;
    padding: 36px 20px 56px;
    background:
        radial-gradient(circle at top left, rgba(244, 196, 48, 0.18), transparent 30%),
        radial-gradient(circle at top right, rgba(29, 158, 117, 0.12), transparent 35%),
        linear-gradient(180deg, #f5f7f4 0%, #edf3ef 100%);
}

.dkm-form-shell {
    max-width: 980px;
    margin: 0 auto;
}

.dkm-form-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border-radius: 999px;
    background: #ffffff;
    color: #0f6e56;
    text-decoration: none;
    border: 1px solid #d8e7df;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 22px;
}

.dkm-form-back:hover {
    color: #0f6e56;
    text-decoration: none;
    background: #eef8f4;
}

.dkm-form-card {
    background: rgba(255, 255, 255, 0.96);
    border: 1px solid #dde9e2;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 30px 80px rgba(10, 46, 31, 0.08);
}

.dkm-form-hero {
    padding: 32px 34px 26px;
    color: #ffffff;
    background: linear-gradient(135deg, #085041 0%, #0f6e56 42%, #1d9e75 100%);
}

.dkm-form-kicker {
    display: inline-flex;
    padding: 8px 14px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.14);
    border: 1px solid rgba(255, 255, 255, 0.16);
    font-size: 11px;
    letter-spacing: 1.2px;
    font-weight: 700;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.dkm-form-title {
    margin: 0 0 10px;
    font-size: 34px;
    line-height: 1.1;
    font-weight: 700;
    font-family: 'Playfair Display', serif;
}

.dkm-form-subtitle {
    margin: 0;
    max-width: 720px;
    font-size: 14px;
    line-height: 1.8;
    color: rgba(255, 255, 255, 0.82);
}

.dkm-form-body {
    padding: 32px 34px 34px;
}

.dkm-form-alert,
.dkm-form-errors {
    border-radius: 18px;
    padding: 16px 18px;
    margin-bottom: 24px;
    font-size: 14px;
    line-height: 1.7;
}

.dkm-form-alert {
    background: #eef8f4;
    border: 1px solid #cfe7dc;
    color: #0b5a46;
}

.dkm-form-errors {
    background: #fff4f2;
    border: 1px solid #f4d0c8;
    color: #8a2f1f;
}

.dkm-form-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}

.dkm-form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.dkm-form-group.full {
    grid-column: 1 / -1;
}

.dkm-form-label {
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.7px;
    text-transform: uppercase;
    color: #45655a;
}

.dkm-form-input,
.dkm-form-textarea {
    width: 100%;
    border-radius: 16px;
    border: 1px solid #d6e4dc;
    background: #fbfdfc;
    color: #113c31;
    font-size: 14px;
    padding: 14px 16px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
}

.dkm-form-input:focus,
.dkm-form-textarea:focus {
    border-color: #1d9e75;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(29, 158, 117, 0.12);
}

.dkm-form-textarea {
    min-height: 118px;
    resize: vertical;
}

.dkm-form-hint {
    font-size: 12px;
    line-height: 1.6;
    color: #6a8077;
}

.dkm-form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    margin-top: 28px;
    flex-wrap: wrap;
}

.dkm-form-note {
    font-size: 12px;
    line-height: 1.7;
    color: #6a8077;
    max-width: 520px;
}

.dkm-form-btn-wrap {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}

.dkm-form-btn,
.dkm-form-btn-soft {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 150px;
    padding: 13px 22px;
    border-radius: 999px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    border: 1px solid transparent;
}

.dkm-form-btn {
    background: linear-gradient(135deg, #085041 0%, #1d9e75 100%);
    color: #ffffff;
    box-shadow: 0 14px 32px rgba(8, 80, 65, 0.16);
}

.dkm-form-btn:hover {
    color: #ffffff;
    text-decoration: none;
    opacity: 0.94;
}

.dkm-form-btn-soft {
    background: #ffffff;
    color: #0f6e56;
    border-color: #d6e4dc;
}

.dkm-form-btn-soft:hover {
    color: #0f6e56;
    text-decoration: none;
    background: #eff8f4;
}

@media (max-width: 760px) {
    .dkm-form-hero,
    .dkm-form-body {
        padding: 24px 20px;
    }

    .dkm-form-title {
        font-size: 28px;
    }

    .dkm-form-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="dkm-form-page">
    <div class="dkm-form-shell">
        <a href="{{ $cancelUrl }}" class="dkm-form-back">< Kembali ke DKM</a>

        <div class="dkm-form-card">
            <div class="dkm-form-hero">
                <div class="dkm-form-kicker">Manajemen DKM</div>
                <h1 class="dkm-form-title">{{ $formTitle }}</h1>
                <p class="dkm-form-subtitle">{{ $formSubtitle }}</p>
            </div>

            <div class="dkm-form-body">
                @if ($errors->any())
                    <div class="dkm-form-errors">
                        <strong>Data belum bisa disimpan.</strong>
                        <div>Periksa kembali field yang masih kosong atau formatnya belum sesuai.</div>
                    </div>
                @endif

                <div class="dkm-form-alert">
                    Gunakan <strong>Jabatan / Seksi</strong> untuk posisi yang tampil pada kartu anggota, dan isi <strong>Koordinator / Bidang</strong> agar anggota otomatis masuk ke kelompok struktur yang benar.
                </div>

                <form action="{{ $formAction }}" method="POST">
                    @csrf
                    @if ($formMode === 'edit')
                        @method('PUT')
                    @endif

                    <div class="dkm-form-grid">
                        <div class="dkm-form-group">
                            <label class="dkm-form-label" for="nama">Nama Anggota</label>
                            <input
                                id="nama"
                                type="text"
                                name="nama"
                                class="dkm-form-input"
                                value="{{ old('nama', $member->nama ?? '') }}"
                                placeholder="Contoh: Yanuar Kurniawan"
                                required
                            >
                            <div class="dkm-form-hint">Nama lengkap yang akan tampil pada kartu DKM dan halaman detail.</div>
                        </div>

                        <div class="dkm-form-group">
                            <label class="dkm-form-label" for="jabatan">Jabatan / Seksi</label>
                            <input
                                id="jabatan"
                                type="text"
                                name="jabatan"
                                class="dkm-form-input"
                                list="dkm-jabatan-options"
                                value="{{ old('jabatan', $member->jabatan ?? '') }}"
                                placeholder="Contoh: Ketua atau Seksi Qurban"
                                required
                            >
                            <div class="dkm-form-hint">Bisa diisi posisi inti seperti Ketua/Bendahara atau nama seksi seperti Seksi Informasi & Teknologi.</div>
                        </div>

                        <div class="dkm-form-group">
                            <label class="dkm-form-label" for="bio">Koordinator / Bidang</label>
                            <input
                                id="bio"
                                type="text"
                                name="bio"
                                class="dkm-form-input"
                                list="dkm-koordinator-options"
                                value="{{ old('bio', $member->bio ?? '') }}"
                                placeholder="Contoh: Koordinator Hubungan Masyarakat & Informasi"
                            >
                            <div class="dkm-form-hint">Untuk Ketua/Sekretaris/Bendahara, isi misalnya <strong>Pengurus inti DKM 2026</strong>.</div>
                        </div>

                        <div class="dkm-form-group">
                            <label class="dkm-form-label" for="foto">Foto</label>
                            <input
                                id="foto"
                                type="text"
                                name="foto"
                                class="dkm-form-input"
                                value="{{ old('foto', $member->foto ?? '') }}"
                                placeholder="URL foto atau path gambar"
                            >
                            <div class="dkm-form-hint">Boleh dikosongkan. Sistem akan menampilkan inisial nama bila foto belum ada.</div>
                        </div>

                        <div class="dkm-form-group">
                            <label class="dkm-form-label" for="email">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                class="dkm-form-input"
                                value="{{ old('email', $member->email ?? '') }}"
                                placeholder="nama@email.com"
                            >
                        </div>

                        <div class="dkm-form-group">
                            <label class="dkm-form-label" for="no_hp">No. HP</label>
                            <input
                                id="no_hp"
                                type="text"
                                name="no_hp"
                                class="dkm-form-input"
                                value="{{ old('no_hp', $member->no_hp ?? '') }}"
                                placeholder="08xxxxxxxxxx"
                            >
                        </div>

                        <div class="dkm-form-group full">
                            <label class="dkm-form-label" for="alamat">Alamat</label>
                            <textarea
                                id="alamat"
                                name="alamat"
                                class="dkm-form-textarea"
                                placeholder="Alamat atau catatan domisili anggota DKM"
                            >{{ old('alamat', $member->alamat ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="dkm-form-actions">
                        <div class="dkm-form-note">
                            Data yang disimpan dari form ini akan langsung dipakai oleh halaman struktur DKM, jadi pengisian bidang dan seksi yang konsisten akan membuat tampilan organisasi jauh lebih rapi.
                        </div>

                        <div class="dkm-form-btn-wrap">
                            <a href="{{ $cancelUrl }}" class="dkm-form-btn-soft">Batal</a>
                            <button type="submit" class="dkm-form-btn">{{ $submitLabel }}</button>
                        </div>
                    </div>
                </form>

                <datalist id="dkm-koordinator-options">
                    @foreach ($coordinatorOptions ?? [] as $option)
                        <option value="{{ $option }}"></option>
                    @endforeach
                </datalist>

                <datalist id="dkm-jabatan-options">
                    @foreach ($jabatanOptions ?? [] as $option)
                        <option value="{{ $option }}"></option>
                    @endforeach
                </datalist>
            </div>
        </div>
    </div>
</div>
