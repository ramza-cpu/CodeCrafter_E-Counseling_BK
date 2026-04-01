@extends('layouts.app')

@section('title', 'Dashboard Ortu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/ortu/dashboard.css') }}">
@endpush

@section('content')

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">{{ config('app.name') }}</h2>
</div>

    <!-- Main Content -->
    <section class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h2 class="logo">LOGO</h2>
                <h1>Hello, {{ $user->username }}</h1>
                <p class="subtitle">Selamat datang kembali, Pantau perkembangan anak Anda hari ini</p>
            </div>
        </header>

        <!-- Dashboard Grid -->
        <div class="">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Notifikasi Card -->
                <div class="card notifications-card">
                    <div class="notification-list">
 {{-- Pelanggaran --}}
@forelse($pelanggaran as $item)
    <div class="notification-item {{ $item->poin >= 20 ? 'urgent' : '' }}">
        <i class="fas fa-exclamation-triangle"></i>
        <div class="notif-content">
            <p class="notif-title">
                {{ $siswa->nama }} melakukan pelanggaran: {{ $item->nama_pelanggaran }}
            </p>
            <p class="notif-date">
                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
            </p>
        </div>
    </div>
@empty
    <div class="notification-item">
        <i class="fas fa-info-circle"></i>
        <div class="notif-content">
            <p class="notif-title">Tidak ada pelanggaran terbaru</p>
        </div>
    </div>
@endforelse

{{-- Surat --}}
@if($surat)
    <div class="notification-item">
        <i class="fas fa-envelope"></i>
        <div class="notif-content">
            <p class="notif-title">
                {{ $surat->jenis_surat }} untuk {{ $siswa->nama }}
            </p>
            <p class="notif-date">
                {{ \Carbon\Carbon::parse($surat->tanggal_cetak)->format('d M Y') }}
            </p>
        </div>
    </div>
@endif

{{-- Skor --}}
<div class="notification-item">
    <i class="fas fa-bell"></i>
    <div class="notif-content">
        <p class="notif-title">
            Skor {{ $siswa->nama }} saat ini: <strong>{{ $skor }}</strong>
        </p>
        <p class="notif-date">Update terbaru</p>
    </div>
</div>
                </div>




            <!-- Right Column -->
            <div class="right-column">
                <!-- Points Card -->
                <div class="card points-card">
                    <div class="points-header">
                        <h3>Rekap poin</h3>
                        
                    </div>
                    <canvas id="pointsChart"></canvas>
                </div>


    </section>
@endsection

@push('scripts')
<script>
    window.dashboardData = {
        tertib: {{ $tertib }},
        pembinaan: {{ $pembinaan }}
    };
</script>
<script src="{{ asset('js/ortu/dashboard.js') }}"></script>
@endpush