@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/siswa/dashboard.css') }}">
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
                <h1>Hello, {{ $siswa->nama }}</h1>
                <p class="subtitle">Selamat datang kembali, semoga harimu produktif ya</p>
            </div>
        </header>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Notifikasi Card -->
                <div class="card notifications-card">
<div class="notification-list">

    {{-- 1. Pelanggaran --}}
    @foreach($pelanggaran as $item)
        <div class="notification-item {{ $item->poin >= 20 ? 'urgent' : '' }}">
            <i class="fas fa-exclamation-triangle"></i>
            <div class="notif-content">
                <p class="notif-title">
                    Pelanggaran: {{ $item->nama_pelanggaran }}
                </p>
                <p class="notif-date">
                    {{ $item->created_at }}
                </p>
            </div>
        </div>
    @endforeach

    {{-- 2. Surat --}}
    @if($surat)
        <div class="notification-item">
            <i class="fas fa-envelope"></i>
            <div class="notif-content">
                <p class="notif-title">
                    Surat Peringatan diterbitkan
                </p>
                <p class="notif-date">
                    {{ $surat->created_at->format('M d Y') }}
                </p>
            </div>
        </div>
    @endif

    {{-- 3. Skor --}}
    <div class="notification-item">
        <i class="fas fa-bell"></i>
        <div class="notif-content">
            <p class="notif-title">
                Skor kamu saat ini: {{ $skor }}
            </p>
            <p class="notif-date">
                Update terbaru
            </p>
        </div>
    </div>

</div>
                </div>

                
            </div>


                <!-- Points Card -->
                <div class="card points-card">
                    <div class="points-header">
                        <h3>Rekap poin</h3>
                        <div class="points-tabs">
                            <button class="tab-btn active">Tertib</button>
                            <button class="tab-btn">Pembinaan</button>
                        </div>
                    </div>
                    <canvas id="pointsChart"></canvas>
                </div>

                <!-- Mood Analysis Card -->
                <div class="card mood-card">
                    <h3>Mood Analysis</h3>
                    
                    <!-- Mood Selector -->
                    <div class="mood-selector">
                        <button class="mood-btn" data-mood="terrible">
                            <span class="emoji">😢</span>
                            <span class="mood-label">terrible</span>
                        </button>
                        <button class="mood-btn" data-mood="bad">
                            <span class="emoji">😟</span>
                            <span class="mood-label">bad</span>
                        </button>
                        <button class="mood-btn" data-mood="okay">
                            <span class="emoji">😐</span>
                            <span class="mood-label">okay</span>
                        </button>
                        <button class="mood-btn" data-mood="good">
                            <span class="emoji">🙂</span>
                            <span class="mood-label">good</span>
                        </button>
                        <button class="mood-btn" data-mood="great">
                            <span class="emoji">😄</span>
                            <span class="mood-label">great</span>
                        </button>
                    </div>

                    <!-- Mood Chart -->
                    <div class="mood-chart-header">
                        <h4>This week</h4>
                        <div class="mood-nav">
                            <button class="mood-nav-btn"><i class="fas fa-chevron-left"></i></button>
                            <button class="mood-nav-btn"><i class="fas fa-chevron-right"></i></button>
                        </div>
                    </div>
                    <canvas id="moodChart"></canvas>
                </div>

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
<script src="{{ asset('js/siswa/dashboard.js') }}"></script>
@endpush