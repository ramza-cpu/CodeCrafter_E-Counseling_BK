    <div class="sidebar-overlay" id="sidebarOverlay"></div>

<aside class="sidebar" id="sidebar">
    <div class="logo-section">
        <div class="hamburger">
            <i class="fas fa-bars"></i>
        </div>
    </div>

    <nav class="nav-menu">

        {{-- ADMIN MENU --}}
        @if(session('role') == 'admin')
            <a href="/admin" class="nav-item"><i class="fas fa-home"></i></a>
            <a href="/admin/chat" class="nav-item"><i class="fas fa-comment"></i></a>
            <a href="/admin/scan" class="nav-item"><i class="fas fa-qrcode"></i></a>
            <a href="/admin/user" class="nav-item"><i class="fas fa-user-plus"></i></a>
        @endif

        {{-- SISWA MENU --}}
        @if(session('role') == 'siswa')
            <a href="/siswa" class="nav-item"><i class="fas fa-home"></i></a>
            <a href="/siswa/chat" class="nav-item"><i class="fas fa-comment"></i></a>
            <a href="/siswa/riwayat" class="nav-item"><i class="fas fa-file-alt"></i></a>
        @endif

        {{-- GURU MENU --}}
        @if(session('role') == 'guru')
            <a href="/guru" class="nav-item"><i class="fas fa-home"></i></a>
            <a href="/guru/chat" class="nav-item"><i class="fas fa-comment"></i></a>
        @endif


    </nav>

<div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
</aside>

<!-- 
    <aside class="sidebar" id="sidebar">
        <div class="logo-section">
            <div class="hamburger">
                <i class="fas fa-bars"></i>
            </div>
        </div>
        <nav class="nav-menu">
            <a href="#" class="nav-item active"><i class="fas fa-home"></i></a>
            <a href="#" class="nav-item"><i class="fas fa-comment"></i></a>
            <a href="#" class="nav-item"><i class="fas fa-qrcode"></i></a>
            <a href="#" class="nav-item"><i class="fas fa-user-plus"></i></a>
            <a href="#" class="nav-item"><i class="fas fa-print"></i></a>
            <a href="#" class="nav-item"><i class="fas fa-file-alt"></i></a>
        </nav>
        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn" title="Logout">
                    <i class="fas fa-sign-out-alt"></i>
                </button>
            </form>
        </div>
    </aside> -->