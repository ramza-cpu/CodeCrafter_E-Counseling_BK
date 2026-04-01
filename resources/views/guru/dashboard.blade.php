 @extends('layouts.app')

@section('title', 'Dashboard Guru')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/guru/dashboard.css') }}">
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
          <h1>Hello, {{ $guru->nama }}</h1>
          <p class="sub">Ada beberapa update baru untuk anda</p>
        </div>

        <div class="cards">
          <div class="stat-card">
            <div class="icon">👥</div>
            <div>
              <span class="label">TOTAL MURID</span>
              <h2>{{ number_format($totalMurid) }}</h2>
              <small>murid SMK BBC</small>
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
@forelse($notifDarurat as $item)
<div class="notif-item">
    <b>{{ $item->nama }}</b>
    <p>{{ $item->jenis_surat }}</p>
    <span>{{ \Carbon\Carbon::parse($item->tanggal_cetak)->format('d M Y') }}</span>
</div>
@empty
<p>Tidak ada notifikasi</p>
@endforelse
        </div>

        <div class="widget-card">
          <h4>Rekap poin</h4>
          <canvas id="donutChart"></canvas>

@php
$total = $tertib + $pembinaan + $prioritas;
@endphp

<div class="rekap-row">
    <span>Tertib</span>
    <span>{{ $total ? round(($tertib/$total)*100,1) : 0 }}%</span>
</div>

<div class="rekap-row">
    <span>Pembinaan</span>
    <span>{{ $total ? round(($pembinaan/$total)*100,1) : 0 }}%</span>
</div>

<div class="rekap-row">
    <span>Prioritas/SP</span>
    <span>{{ $total ? round(($prioritas/$total)*100,1) : 0 }}%</span>
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


      </div>
@endsection

@push('scripts')
<script>
window.guruData = {
    statistikBulanan: @json($statistikBulanan),
    kategoriKasus: @json($kategoriKasus),
    rekap: {
        tertib: {{ $tertib }},
        pembinaan: {{ $pembinaan }},
        prioritas: {{ $prioritas }}
    }
};
</script>
<script src="{{ asset('js/guru/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

</body>
</html>