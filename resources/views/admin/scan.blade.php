@extends('layouts.app')

@section('title', 'Scan QR Code')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/scan.css') }}">
@endpush

@section('content')

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">{{ config('app.name') }}</h2>
</div>

<section class="main-content">
    <h1>Scan QR Murid</h1>

    <div class="scan-wrapper">

        <!-- SCANNER -->
        <div class="scan-card">
            <h3>Scan Kamera</h3>
            <div id="reader"></div>
            <button class="btn-primary" onclick="startScanner()">Aktifkan Kamera</button>

            <hr style="margin: 15px 0; border: none; border-top: 1px solid #e0e0e0;" />

            <h4>Atau Input Manual</h4>
            <input
                type="text"
                id="manualInput"
                placeholder="Masukkan NISN / Kode QR"
            />
            <button class="btn-secondary" onclick="manualScan()">Proses Manual</button>

            <!-- FORM TERSEMBUNYI UNTUK KIRIM KE BACKEND -->
            <form id="scanForm" method="POST" action="{{ route('scan.find') }}">
                @csrf
                <input type="hidden" name="nisn" id="nisnHidden">
            </form>
        </div>

        <!-- DATA -->
        <div class="scan-card">
            <h3>Data Murid</h3>
            <div id="result">

                @if(isset($siswa))
                    <div class="student-data">
                        <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
                        <p><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
                        <p><strong>NISN:</strong> {{ $siswa->nisn }}</p>
                        <p><strong>Skor:</strong> {{ $siswa->skor }}</p>

                        <a href="{{ route('akumulasi.create', $siswa->id_siswa) }}"
                           class="btn-merah"
                           style="margin-top:10px; margin-left:20px; display:inline-block;">
                            Input Pelanggaran
                        </a>
                    </div>
                @else
                    <p class="no-data">
                        Belum ada data. Silakan scan QR atau input manual.
                    </p>
                @endif

            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="{{ asset('js/admin/scan.js') }}"></script>
@endpush