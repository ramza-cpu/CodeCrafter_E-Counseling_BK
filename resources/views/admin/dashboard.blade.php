 @extends('layouts.app')

@section('title', 'Dashboard Admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush


@section('content')
        <!-- Mobile Top Bar: hanya muncul di mobile -->

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">Smart E-Counsel</h2>
</div>
   <!-- HEADER -->
      <div class="top-section">
        <div class="welcome">
          <p class="date"></p>
          <h1>Hello, Admin!</h1>
          <p class="sub">Ada beberapa update baru untuk anda</p>
        </div>

        <div class="cards">
          <div class="stat-card">
            <div class="icon">👥</div>
            <div>
              <span class="label">TOTAL MURID</span>
              <h2>1,674</h2>
              <small>murid SMK BBC</small>
            </div>
          </div>

          <div class="stat-card">
            <div class="icon">👩‍🏫</div>
            <div>
              <span class="label">SESI KONSELING</span>
              <h2>132</h2>
              <small>sesi bulan ini</small>
            </div>
          </div>

          <div class="stat-card">
            <div class="icon">🏃</div>
            <div>
              <span class="label">BUTUH PERHATIAN</span>
              <h2>12</h2>
              <small>perlu tindak lanjut</small>
            </div>
          </div>
        </div>
      </div>

      <!-- GRID ATAS -->
      <div class="top-widgets">
        <div class="widget-card">
          <h4>Statistik Bulanan</h4>
          <canvas id="lineChart"></canvas>
        </div>

        <div class="widget-card">
          <h4>Kategori Kasus</h4>
          <canvas id="barChart"></canvas>
        </div>
      </div>

      <!-- GRID BAWAH -->
      <div class="bottom-widgets">
        <div class="widget-card">
          <h4>Notifikasi darurat 🚨</h4>
          <div class="notif-item">
            <b>Bimo</b>
            <p>SP3 diterbitkan</p>
            <span>Feb 02, 2026</span>
          </div>
          <div class="notif-item">
            <b>Wati Sukosih XII RPL 7</b>
            <p>Mendapat teguran</p>
            <span>Feb 02, 2026</span>
          </div>
        </div>

        <div class="widget-card">
          <h4>Rekap poin</h4>
          <canvas id="donutChart"></canvas>

          <div class="rekap-row"><span>Tertib</span><span>62.5%</span></div>
          <div class="rekap-row"><span>Pembinaan</span><span>25%</span></div>
          <div class="rekap-row">
            <span>Prioritas/SP</span><span>12.5%</span>
          </div>
        </div>

        <div class="widget-card">
          <h4>Tindak lanjut</h4>
          <ul class="todo-list">
            <li>Hubungi orang tua - Bimo</li>
            <li>Follow up SP3</li>
            <li>Verifikasi 2 laporan</li>
            <li>Input pelanggaran</li>
          </ul>
        </div>

        <div class="widget-card">
          <h4>Notifikasi pesan 💬</h4>

          <div class="message-item">
            <div class="avatar">S</div>
            <div>
              <b>Strawberry shortcake</b>
              <p>Izin terlambat</p>
              <span>1m</span>
            </div>
          </div>

          <div class="message-item">
            <div class="avatar">I</div>
            <div>
              <b>Ikan terbang</b>
              <p>Meminta bimbingan</p>
              <span>12m</span>
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