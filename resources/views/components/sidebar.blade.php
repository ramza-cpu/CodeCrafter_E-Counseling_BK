

<aside class="sidebar" id="sidebar">

    <div class="sidebar-top">
        <h2 class="logo">Smart E-Counsel</h2>
        <button class="hamburger" id="hamburgerBtn" type="button">
            ☰
        </button>
    </div>

    <ul class="menu">

        {{-- DASHBOARD (Semua Role) --}}
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
        </li>

        {{-- ================= ADMIN ================= --}}
         @if(session('role') == 'admin')

            <li class="{{ request()->routeIs('pesan.*') ? 'active' : '' }}">
                <a href="{{ route('pesan') }}">💬 Pesan</a>
            </li>

            <li class="{{ request()->routeIs('akumulasi.*') ? 'active' : '' }}">
                <a href="{{ route('akumulasi') }}">⭐ Akumulasi</a>
            </li>

            <li class="{{ request()->routeIs('scan.*') ? 'active' : '' }}">
                <a href="{{ route('scan') }}">📷 Scan QR</a>
            </li>

            <li class="{{ request()->routeIs('cetak.*') ? 'active' : '' }}">
                <a href="{{ route('cetak') }}">🖨 Cetak</a>
            </li>

            <li class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                <a href="{{ route('riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif


        {{-- ================= MURID ================= --}}
          @if(session('role') == 'murid')

            <li class="{{ request()->routeIs('pesan.*') ? 'active' : '' }}">
                <a href="{{ route('pesan') }}">💬 Pesan</a>
            </li>

            <li class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                <a href="{{ route('riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif


        {{-- ================= GURU ================= --}}
  @if(session('role') == 'guru')

            <li class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                <a href="{{ route('riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif


        {{-- ================= ORANG TUA ================= --}}
        @if(session('role') == 'orang_tua')

            <li class="{{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
                <a href="{{ route('riwayat') }}">🕒 Riwayat</a>
            </li>

        @endif

    </ul>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="logout">Keluar</button>
    </form>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>