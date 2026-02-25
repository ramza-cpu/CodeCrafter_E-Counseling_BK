 @extends('layouts.app')

@section('title', 'Scan QR Code')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/scan.css') }}">
@endpush


@section('content')
        <!-- Mobile Top Bar: hanya muncul di mobile -->

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">Smart E-Counsel</h2>
</div>
         <!-- CONTENT -->
        <section class="main-content">
          <h1>Scan QR Murid</h1>

          <div class="scan-wrapper">
            
            <!-- SCANNER -->
            <div class="scan-card">
              <h3>Scan Kamera</h3>
              <div id="reader"></div>
              <button class="btn-primary" onclick="startScanner()">Aktifkan Kamera</button>

              <hr style="margin: 15px 0; border: none; border-top: 1px solid #e0e0e0;" />

              <h4>Atau Input Manual</h4>
              <input
                type="text"
                id="manualInput"
                placeholder="Masukkan NISN / Kode QR"
              />
              <button class="btn-secondary" onclick="manualScan()">Proses Manual</button>
            </div>

            <!-- DATA -->
            <div class="scan-card">
              <h3>Data Murid</h3>
              <div id="result">
                <p class="no-data">Belum ada data. Silakan scan QR atau input manual.</p>
              </div>
            </div>
            
          </div>
        </section>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/scan.js') }}"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
@endpush

</body>
</html>