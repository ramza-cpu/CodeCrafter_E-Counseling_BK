 @extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush


@section('header')
        <!-- Mobile Top Bar: hanya muncul di mobile -->
        <div class="mobile-topbar">
            <button class="mobile-hamburger" id="mobileHamburgerBtn">
                <i class="fas fa-bars"></i>
            </button>

        </div>

        <!-- Header -->
        <header class="header">
            <div class="logo-text">
            <img src="images/logo.png" width="90px" height="90px" alt="">
                <p class="date"> {{ now()->timezone('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}</p>
                <h1>Hello, Admin! 👋</h1>
                <p class="subtitle">Ada beberapa update baru untuk anda</p>
            </div>
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div class="stat-info">
                        <p class="stat-label">TOTAL MURID</p>
                        <h3>1,674</h3>
                        <p class="stat-sub">murid SMK BKC</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="stat-info">
                        <p class="stat-label">SESI KONSELING</p>
                        <h3>132</h3>
                        <p class="stat-sub">sesi bulan ini</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon"><i class="fas fa-user-clock"></i></div>
                    <div class="stat-info">
                        <p class="stat-label">BUTUH PERHATIAN</p>
                        <h3>12</h3>
                        <p class="stat-sub">perlu tindak lanjut</p>
                    </div>
                </div>
            </div>
        </header>
@endsection


        @section('content')
        <div class="dashboard-grid">

            <!-- order mobile: 1 -->
            <div class="card card-statistik">
                <h3>Statistik Bulanan</h3>
                <div class="percentage">82.08%</div>
                <canvas id="lineChart"></canvas>
            </div>

            <!-- order mobile: 2 -->
            <div class="card card-kategori">
                <h3>Kategori Kasus</h3>
                <canvas id="barChart"></canvas>
            </div>

            <!-- disembunyikan di mobile -->
            <div class="card notes-card card-catatan">
                <h3>catatan hari ini! <span class="emoji">👋</span></h3>
                <div class="notes-content">
                    <p>Tidak ada catatan untuk hari ini</p>
                </div>
            </div>

            <!-- order mobile: 3 (kiri) -->
            <div class="card action-card card-tindak">
                <h3>Tindak lanjut</h3>
                <div class="action-list">
                    <div class="action-item"><span class="action-dot red"></span><span>Hubungi orang tua - Bima</span></div>
                    <div class="action-item"><span class="action-dot red"></span><span>Follow up SP3</span></div>
                    <div class="action-item"><span class="action-dot yellow"></span><span>Verifikasi 2 Laporan</span></div>
                    <div class="action-item"><span class="action-dot yellow"></span><span>Input pelanggaran</span></div>
                    <div class="action-item"><span class="action-dot green"></span><span>Cetak rekap</span></div>
                    <div class="action-item"><span class="action-dot red"></span><span>Sidak Bullying</span></div>
                    <div class="action-item"><span class="action-dot green"></span><span>Follow up 30%</span></div>
                </div>
            </div>

            <!-- order mobile: 4 (kanan, berdampingan dengan Tindak Lanjut) -->
            <div class="card card-rekap">
                <h3>Rekap poin</h3>
                <canvas id="doughnutChart"></canvas>
                <div class="legend-grid">
                    <div class="legend-item"><span class="legend-color" style="background:#4CAF50;"></span><span>Terliti 62.5%</span></div>
                    <div class="legend-item"><span class="legend-color" style="background:#2196F3;"></span><span>Pembinaan 25%</span></div>
                    <div class="legend-item"><span class="legend-color" style="background:#FFC107;"></span><span>Prioritas/SP 12.5%</span></div>
                </div>
            </div>

            <!-- order mobile: 5 -->
            <div class="card notification-card card-notifikasi">
                <h3>Notifikasi darurat 🚨</h3>
                <div class="notification-list">
                    <div class="notification-item">
                        <div class="notif-icon emergency"><i class="fas fa-fire"></i></div>
                        <div class="notif-content">
                            <p class="notif-title">bima sakti gunung X BOP</p>
                            <p class="notif-sub">SP 3 diterbitkan</p>
                            <p class="notif-date"><i class="far fa-calendar"></i> Feb 02, 2026</p>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notif-icon warning"><i class="fas fa-exclamation-triangle"></i></div>
                        <div class="notif-content">
                            <p class="notif-title">Wati Sukaesih XII RPL</p>
                            <p class="notif-sub">Mendeteksi batas poin</p>
                            <p class="notif-date"><i class="far fa-calendar"></i> Feb 02, 2026</p>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notif-icon info"><i class="fas fa-info-circle"></i></div>
                        <div class="notif-content">
                            <p class="notif-title">Mimi Peri XI DKV</p>
                            <p class="notif-sub">3+ poin pelanggaran 1 hari</p>
                            <p class="notif-date"><i class="far fa-calendar"></i> Feb 02, 2026</p>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notif-icon building"><i class="fas fa-building"></i></div>
                        <div class="notif-content">
                            <p class="notif-title">Jule X BRP 9</p>
                            <p class="notif-sub">Laporan bullying</p>
                            <p class="notif-date"><i class="far fa-calendar"></i> Feb 02, 2026</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- order mobile: 6 -->
            <div class="card activity-card card-activity">
                <div class="activity-list">
                    <div class="activity-item">
                        <img src="https://i.pravatar.cc/40?img=1" alt="User" class="activity-avatar">
                        <div class="activity-content">
                            <p class="activity-title">strawberry shortcake</p>
                            <p class="activity-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                        <span class="activity-time">10.00</span>
                    </div>
                    <div class="activity-item">
                        <img src="https://i.pravatar.cc/40?img=2" alt="User" class="activity-avatar">
                        <div class="activity-content">
                            <p class="activity-title">han terbang</p>
                            <p class="activity-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                        <span class="activity-time">10.21</span>
                    </div>
                    <div class="activity-item">
                        <img src="https://i.pravatar.cc/40?img=3" alt="User" class="activity-avatar">
                        <div class="activity-content">
                            <p class="activity-title">kembaran windut</p>
                            <p class="activity-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                        <span class="activity-time">10.39</span>
                    </div>
                    <div class="activity-item">
                        <img src="https://i.pravatar.cc/40?img=4" alt="User" class="activity-avatar">
                        <div class="activity-content">
                            <p class="activity-title">pacar saobin</p>
                            <p class="activity-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                        <span class="activity-time">11.02</span>
                    </div>
                    <div class="activity-item">
                        <img src="https://i.pravatar.cc/40?img=5" alt="User" class="activity-avatar">
                        <div class="activity-content">
                            <p class="activity-title">papeda mang ucup</p>
                            <p class="activity-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                        <span class="activity-time">11.20</span>
                    </div>
                </div>
            </div>

        </div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

</body>
</html>