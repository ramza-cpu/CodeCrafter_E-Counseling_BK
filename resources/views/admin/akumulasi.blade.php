@extends('layouts.app')

@section('title', 'Akumulasi Pelanggaran')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/akumulasi.css') }}">
@endpush

@section('content')

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">Smart E-Counsel</h2>
</div>


<section class="main-content">
    <h1>Input Pelanggaran</h1>

    <div class="scan-wrapper">

        <div class="scan-card">

            <h3>Data Siswa</h3>
            <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
            <p><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
            <p><strong>Skor Saat Ini:</strong> {{ $siswa->skor }}</p>

            <hr>

            <form method="POST" action="{{ route('akumulasi.store') }}">
                @csrf

                <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}">

                <label>Pilih Pelanggaran</label>
<select name="id_jenis_pelanggaran" id="jenisSelect" required>
    <option value="">-- Pilih Pelanggaran --</option>
    @foreach($jenis as $item)
        <option value="{{ $item->id_jenis_pelanggaran }}" data-poin="{{ $item->poin }}">
            {{ $item->nama_pelanggaran }} ({{ $item->poin }} poin)
        </option>
    @endforeach
</select>

                <label>Skor</label>
<input type="number" name="poin" id="poinInput" readonly>

                <label>Keterangan</label>
                <textarea name="keterangan"
                          rows="3"
                          placeholder="Masukkan keterangan pelanggaran"
                          required></textarea>

                <button type="submit" class="btn-primary">
                    Simpan Pelanggaran
                </button>

            </form>

        </div>

    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/akumulasi.js') }}"></script>
@endpush