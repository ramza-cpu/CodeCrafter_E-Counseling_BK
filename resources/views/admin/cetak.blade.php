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
    <h2 class="mobile-logo">Smart E-Counsel</h2>
</div>

<section class="main-content">

    <h1>Cetak Laporan</h1>

    <button onclick="window.print()" class="btn-print">
        🖨 Cetak
    </button>

    <div class="print-wrapper">

        <div class="print-card">

            <h3 style="margin-bottom: 20px;">Data Laporan</h3>

            <table class="print-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Pelanggaran</th>
                        <th>Poin</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>

                <tbody>
                    @for($i = 1; $i <= 35; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>Nama Siswa {{ $i }}</td>
                        <td>Pelanggaran {{ $i }}</td>
                        <td>{{ rand(1,20) }}</td>
                        <td>{{ date('d-m-Y') }}</td>
                    </tr>
                    @endfor
                </tbody>

            </table>

        </div>

    </div>

</section>
@endsection
