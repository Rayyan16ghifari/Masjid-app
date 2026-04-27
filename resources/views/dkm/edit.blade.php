@extends('layouts.app')

@section('content')
    @include('dkm.partials.form', [
        'd' => $d,
        'formMode' => 'edit',
        'formTitle' => 'Edit Data Anggota DKM',
        'formSubtitle' => 'Perbarui data anggota, bidang koordinator, atau seksi agar struktur DKM selalu akurat dan siap ditampilkan.',
        'formAction' => route('dkm.update', $d->id),
        'submitLabel' => 'Simpan Perubahan',
        'cancelUrl' => route('dkm.show', $d->id),
    ])
@endsection
