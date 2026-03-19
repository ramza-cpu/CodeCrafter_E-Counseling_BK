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
                <h1>Hello, Asep</h1>
                <p class="subtitle">Selamat datang kembali, semoga harimu produktif ya</p>
            </div>
        </header>

        <!-- Dashboard Grid -->
        <div class="">
            <!-- Left Column -->
            <div class="left-column">
                <!-- Notifikasi Card -->
                <div class="card notifications-card">
                    <div class="notification-list">
                        <div class="notification-item urgent">
                            <i class="fas fa-exclamation-triangle"></i>
                            <div class="notif-content">
                                <p class="notif-title">Rasyad Pelanggaran, @user</p>
                                <p class="notif-date">Feb 02 2026</p>
                            </div>
                            <button class="notif-more">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>

                        <div class="notification-item">
                            <i class="fas fa-bell"></i>
                            <div class="notif-content">
                                <p class="notif-title">SP 3 selesaikan</p>
                                <p class="notif-date">Feb 02 2026</p>
                            </div>
                            <button class="notif-more">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>

                        <div class="notification-item">
                            <i class="fas fa-bell"></i>
                            <div class="notif-content">
                                <p class="notif-title">Mendeteksi batas poin</p>
                                <p class="notif-date">Feb 02 2026</p>
                            </div>
                            <button class="notif-more">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>

                        <div class="notification-item">
                            <i class="fas fa-bell"></i>
                            <div class="notif-content">
                                <p class="notif-title">J+ poin pelanggaran 1 hari</p>
                                <p class="notif-date">Feb 02 2026</p>
                            </div>
                            <button class="notif-more">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>

                        <div class="notification-item">
                            <i class="fas fa-bell"></i>
                            <div class="notif-content">
                                <p class="notif-title">Laporan bullying</p>
                                <p class="notif-date">Feb 02 2026</p>
                            </div>
                            <button class="notif-more">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </div>
                    </div>
                </div>




            <!-- Right Column -->
            <div class="right-column">
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


    </section>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="{{ asset('js/ortu/dashboard.js') }}"></script>
@endpush