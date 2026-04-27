@extends('layouts.app')

@section('content')
    @include('dkm.partials.form', [
        'formMode' => 'create',
        'formTitle' => 'Tambah Anggota DKM',
        'formSubtitle' => 'Masukkan anggota baru ke dalam struktur DKM lengkap dengan seksi dan koordinatornya agar susunan organisasi tetap tertata.',
        'formAction' => route('dkm.store'),
        'submitLabel' => 'Simpan Anggota',
    ])
@endsection
