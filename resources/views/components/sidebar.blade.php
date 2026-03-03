<aside class="sidebar" id="sidebar">

    <div class="sidebar-top">
        <h2 class="logo">Smart E-Counsel</h2>
        <button class="hamburger" id="hamburgerBtn" type="button">
            ☰
        </button>
    </div>

    <ul class="menu">

        {{-- DASHBOARD --}}
        @auth
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
        </li>
        @endauth


        {{-- ================= ADMIN ================= --}}
        @auth
        @if(Auth::user()->role == 'admin')

            <li class="{{ request()->routeIs('pesan') ? 'active' : '' }}">
                <a href="{{ route('pesan') }}">💬 Pesan</a>
            </li>

            <li class="{{ request()->routeIs('scan') ? 'active' : '' }}">
                <a href="{{ route('scan') }}">📷 Scan QR</a>
            </li>

            <li class="{{ request()->routeIs('akumulasi.create') ? 'active' : '' }}">
                <a href="#">⭐ Akumulasi</a>
            </li>

            <li class="{{ request()->routeIs('cetak') ? 'active' : '' }}">
                <a href="{{ route('cetak') }}">🖨 Cetak</a>
            </li>

            <li class="{{ request()->routeIs('riwayat') ? 'active' : '' }}">
                <a href="{{ route('riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif
        @endauth


        {{-- ================= SISWA ================= --}}
        @auth
        @if(Auth::user()->role == 'siswa')

            <li class="{{ request()->routeIs('siswa.chat') ? 'active' : '' }}">
                <a href="{{ route('siswa.chat') }}">💬 Pesan</a>
            </li>

            <li class="{{ request()->routeIs('riwayat') ? 'active' : '' }}">
                <a href="{{ route('riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif
        @endauth


        {{-- ================= GURU ================= --}}
        @auth
        @if(Auth::user()->role == 'guru')

            <li class="{{ request()->routeIs('riwayat') ? 'active' : '' }}">
                <a href="{{ route('riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif
        @endauth


        {{-- ================= ORANG TUA ================= --}}
        @auth
        @if(Auth::user()->role == 'ortu')

            <li class="{{ request()->routeIs('ortu.riwayat') ? 'active' : '' }}">
                <a href="{{ route('ortu.riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif
        @endauth

    </ul>

    @auth
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout">Keluar</button>
    </form>
    @endauth

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>