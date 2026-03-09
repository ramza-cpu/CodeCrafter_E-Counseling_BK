@extends('layouts.app')

@section('title', 'Cetak')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/cetak.css') }}">
@endpush

@section('content')
<!-- Mobile Topbar -->
<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">{{ config('app.name') }}</h2>
</div>

<section class="main-content">

    <h1>Cetak Laporan</h1>

    <button onclick="window.print()" class="btn-print">
        🖨 Cetak
    </button>

    <div class="print-wrapper">

<div class="print-card">
    <h3>Data Laporan</h3>
    
    <!-- Wrapper untuk horizontal scroll -->
    <div class="table-container">
        <table class="print-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Siswa</th>
                    <th>Nomor Surat</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal Cetak</th>
                    <th>Isi Surat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
        @for($i = 1; $i <= 35; $i++)

        @php
            $jenisSurat = [
                'Surat Peringatan 1',
                'Surat Peringatan 2',
                'Surat Peringatan 3'
            ];

            $jenis = $jenisSurat[array_rand($jenisSurat)];

            $status = rand(0,1) ? 'pending' : 'dicetak';

            $tanggalCetak = $status == 'dicetak' ? date('d-m-Y') : '-';

            $nomorSurat = 'SP/' . rand(100,999) . '/BK/' . date('Y');

            $isiSurat = 'Pelanggaran tata tertib siswa.';
        @endphp

        <tr>
            <td>{{ $i }}</td>
            <td>Nama Siswa {{ $i }}</td>
            <td>{{ $nomorSurat }}</td>
            <td>{{ $jenis }}</td>
            <td>{{ $tanggalCetak }}</td>
            <td>{{ $isiSurat }}</td>
            <td>
                <span class="{{ $status == 'dicetak' ? 'status-done' : 'status-pending' }}">
                    {{ $status }}
                </span>
            </td>
            <td>
                @if($status == 'pending')
                    <button class="btn-print">Cetak</button>
                @else
                    -
                @endif
            </td>
        </tr>

        @endfor
    </tbody>
</table>

        </div>

    </div>

</section>
@endsection
@push('scripts')
<script src="{{ asset('js/admin/cetak.js') }}"></script>
@endpush