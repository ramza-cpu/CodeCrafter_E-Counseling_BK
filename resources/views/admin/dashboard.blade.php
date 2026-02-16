<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - SMK BKC</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
    <div class="logo-section">
        <div class="hamburger">
            <i class="fas fa-bars"></i>
        </div>
    </div>
    <nav class="nav-menu">
        <a href="#" class="nav-item active">
            <i class="fas fa-home"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-comment"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-qrcode"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-user-plus"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-print"></i>
        </a>
        <a href="#" class="nav-item">
            <i class="fas fa-file-alt"></i>
        </a>
    </nav>

    <!-- TAMBAHKAN INI: Logout Button di Sidebar -->
    <div class="logout-section">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn" title="Logout">
                <i class="fas fa-sign-out-alt"></i>
            </button>
        </form>
    </div>
</aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="logo-text">
                <h2>LOGO</h2>
                <p class="date">Kamis, 05 Februari 2026</p>
                <h1>Hello, Admin!</h1>
                <p class="subtitle">Ada beberapa update baru untuk anda</p>
            </div>

            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">TOTAL MURID</p>
                        <h3>1,674</h3>
                        <p class="stat-sub">murid SMK BKC</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">SESI KONSELING</p>
                        <h3>132</h3>
                        <p class="stat-sub">sesi bulan ini</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-user-clock"></i>
                    </div>
                    <div class="stat-info">
                        <p class="stat-label">BUTUH PERHATIAN</p>
                        <h3>12</h3>
                        <p class="stat-sub">perlu tindak lanjut</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Statistik Bulanan -->
            <div class="card">
                <h3>Statistik Bulanan</h3>
                <div class="percentage">82.08%</div>
                <canvas id="lineChart"></canvas>
            </div>

            <!-- Kategori Kasus -->
            <div class="card">
                <h3>Kategori Kasus</h3>
                <canvas id="barChart"></canvas>
            </div>

            <!-- Catatan Hari Ini -->
            <div class="card notes-card">
                <h3>catatan hari ini! <span class="emoji">👋</span></h3>
                <div class="notes-content">
                    <p>Tidak ada catatan untuk hari ini</p>
                </div>
            </div>

            <!-- Notifikasi Darurat -->
            <div class="card notification-card">
                <h3>Notifikasi darurat 🚨</h3>
                <div class="notification-list">
                    <div class="notification-item">
                        <div class="notif-icon emergency">
                            <i class="fas fa-fire"></i>
                        </div>
                        <div class="notif-content">
                            <p class="notif-title">Dina sakti gunung X BDK 1?</p>
                            <p class="notif-date"><i class="far fa-calendar"></i> 27 Jan 2026</p>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="notif-icon warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="notif-content">
                            <p class="notif-title">Wafi Sulaesih XII RPL 7</p>
                            <p class="notif-date"><i class="far fa-calendar"></i> 27 Jan 2026</p>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="notif-icon info">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="notif-content">
                            <p class="notif-title">Mimi Peri XI DKV 6</p>
                            <p class="notif-date"><i class="far fa-calendar"></i> Feb 02 2026</p>
                        </div>
                    </div>

                    <div class="notification-item">
                        <div class="notif-icon building">
                            <i class="fas fa-building"></i>
                        </div>
                        <div class="notif-content">
                            <p class="notif-title">KELAS X BKP 9</p>
                            <p class="notif-date"><i class="far fa-calendar"></i> Feb 02 2026</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rekap Poin -->
            <div class="card">
                <h3>Rekap poin</h3>
                <canvas id="doughnutChart"></canvas>
                <div class="legend-grid">
                    <div class="legend-item">
                        <span class="legend-color" style="background: #4CAF50;"></span>
                        <span>Terliti 62.5%</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #2196F3;"></span>
                        <span>Pembinaan 25%</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #FFC107;"></span>
                        <span>Prioritas/SP 12.5%</span>
                    </div>
                </div>
            </div>

            <!-- Tindak Lanjut -->
            <div class="card action-card">
                <h3>Tindak lanjut</h3>
                <div class="action-list">
                    <div class="action-item">
                        <span class="action-dot red"></span>
                        <span>Hubungi orang tua - Bima</span>
                    </div>
                    <div class="action-item">
                        <span class="action-dot red"></span>
                        <span>Follow up SP3</span>
                    </div>
                    <div class="action-item">
                        <span class="action-dot yellow"></span>
                        <span>Verifikasi 2 Laporan</span>
                    </div>
                    <div class="action-item">
                        <span class="action-dot yellow"></span>
                        <span>Input pelanggaran</span>
                    </div>
                    <div class="action-item">
                        <span class="action-dot green"></span>
                        <span>Cetak rekap</span>
                    </div>
                    <div class="action-item">
                        <span class="action-dot red"></span>
                        <span>Sidak Bullying</span>
                    </div>
                    <div class="action-item">
                        <span class="action-dot green"></span>
                        <span>Follow up 30%</span>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card activity-card">
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
                            <p class="activity-title">yeye' soalm</p>
                            <p class="activity-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                        <span class="activity-time">11.02</span>
                    </div>

                    <div class="activity-item">
                        <img src="https://i.pravatar.cc/40?img=5" alt="User" class="activity-avatar">
                        <div class="activity-content">
                            <p class="activity-title">colerak pisang gorga</p>
                            <p class="activity-desc">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                        </div>
                        <span class="activity-time">11.20</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
