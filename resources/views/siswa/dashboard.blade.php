<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa - SMK BKC</title>
    <link rel="stylesheet" href="{{ asset('css/siswa/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="hamburger">
            <i class="fas fa-bars"></i>
        </div>
        
        <nav class="nav-menu">
            <a href="#" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Beranda</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-comment"></i>
                <span>Pesan</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-history"></i>
                <span>Riwayat</span>
            </a>
        </nav>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" title="Keluar">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <h2 class="logo">LOGO</h2>
                <h1>Hello, @user!</h1>
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

                <!-- Chat Section -->
                <div class="card chat-card">
                    <div class="chat-item">
                        <div class="chat-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="chat-content">
                            <p class="chat-name">Bu Widia</p>
                            <p class="chat-message">selamat siang ibu, saya mau mencurahankan is..</p>
                        </div>
                        <div class="chat-info">
                            <span class="chat-time">16:07</span>
                            <span class="chat-badge">1</span>
                        </div>
                    </div>

                    <div class="chat-item">
                        <div class="chat-avatar">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <div class="chat-content">
                            <p class="chat-name">Bu Eli</p>
                            <p class="chat-message">selamat siang ibu, saya mau mencurahankan is..</p>
                        </div>
                        <div class="chat-info">
                            <span class="chat-time">16:07</span>
                            <span class="chat-badge">1</span>
                        </div>
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
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/siswa-dashboard.js') }}"></script>
</body>
</html>
