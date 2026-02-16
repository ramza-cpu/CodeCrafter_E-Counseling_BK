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