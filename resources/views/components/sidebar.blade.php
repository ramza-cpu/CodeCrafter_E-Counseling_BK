<aside class="sidebar" id="sidebar">

    <div class="sidebar-top">
        <h2 class="logo">{{ config('app.name') }}</h2>
        <button class="hamburger" id="hamburgerBtn" type="button">
            ☰
        </button>
    </div>

    <ul class="menu">

        {{-- DASHBOARD --}}
        @auth

        @endauth


        {{-- ================= ADMIN ================= --}}
        @auth
        @if(Auth::user()->role == 'admin')
        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
        </li>
            <li class="{{ request()->routeIs('admin.pesan') ? 'active' : '' }}">
                <a href="{{ route('admin.pesan') }}">💬 Pesan</a>
            </li>

            <li class="{{ request()->routeIs('admin.manajemen') ? 'active' : '' }}">
                <a href="{{ route('admin.manajemen') }}">👥 Data Siswa</a>
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
                <li class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <a href="{{ route('siswa.dashboard') }}">🏠 Dashboard</a>
        </li>

            <li class="{{ request()->routeIs('siswa.pesan') ? 'active' : '' }}">
                <a href="{{ route('siswa.pesan') }}">💬 Pesan</a>
            </li>

            <li class="{{ request()->routeIs('siswa.riwayat') ? 'active' : '' }}">
                <a href="{{ route('siswa.riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif
        @endauth


        {{-- ================= GURU ================= --}}
        @auth
        @if(Auth::user()->role == 'guru')
                <li class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            <a href="{{ route('guru.dashboard') }}">🏠 Dashboard</a>
        </li>

            <li class="{{ request()->routeIs('guru.riwayat') ? 'active' : '' }}">
                <a href="{{ route('guru.riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif
        @endauth


        {{-- ================= ORANG TUA ================= --}}
        @auth
        @if(Auth::user()->role == 'ortu')

                        <li class="{{ request()->routeIs('ortu.dashboard') ? 'active' : '' }}">
            <a href="{{ route('ortu.dashboard') }}">🏠 Dashboard</a>

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
<small>(c) {{ date('Y') }} {{ config('app.address') }}</small>
</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>