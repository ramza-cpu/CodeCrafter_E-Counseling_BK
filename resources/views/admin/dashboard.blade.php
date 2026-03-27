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
    <h2 class="mobile-logo">{{ config('app.name') }}</h2>
</div>
   <!-- HEADER -->
      <div class="top-section">
        <div class="welcome">
          <p class="date"></p>
         <h1>Hello, <span id="username">-</span>!</h1>
          <p class="sub">Ada beberapa update baru untuk anda</p>
        </div>

        <div class="cards">
          <div class="stat-card">
            <div class="icon">👥</div>
            <div>
              <span class="label">TOTAL MURID</span>
              <h2 id="totalMurid">-</h2>
              <small>murid SMK BBC</small>
            </div>
          </div>

          <div class="stat-card">
            <div class="icon">🏃</div>
            <div>
              <span class="label">BUTUH PERHATIAN</span>
              <h2 id="butuhPerhatian">-</h2>
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
<div id="notifDarurat">

</div>
        </div>

        <div class="widget-card">
          <h4>Rekap poin</h4>
          <canvas id="donutChart"></canvas>

          <div class="rekap-row"><span>Tertib</span><span id="tertib"></span></div>
          <div class="rekap-row"><span>Pembinaan</span><span id="pembinaan"></span></div>
          <div class="rekap-row"><span>Prioritas/SP</span><span id="prioritas"></span></div>
        </div>

        <div class="widget-card">
          <h4>Tindak lanjut</h4>
<ul class="todo-list" id="tindakLanjut">
        </div>

        <!-- <div class="widget-card">
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
        </div> -->
      </div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

</body>
</html>