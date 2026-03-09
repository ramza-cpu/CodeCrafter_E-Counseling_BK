 @extends('layouts.app')

@section('title', 'Log Siswa')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/riwayat.css') }}">
@endpush


@section('content')
        <!-- Mobile Top Bar: hanya muncul di mobile -->

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">{{ config('app.name') }}</h2>
</div>
      <!-- MAIN CONTENT -->
      <section class="main-content">
        <h1>Log Aktifitas Murid</h1>

        <!-- TOP BAR -->
        <div class="top-bar">
          <div class="search-box">
            <input type="text" placeholder="Cari nama..." />
          </div>

          <div class="card total">
            <h3>Total Pelanggaran</h3>
            <p>76</p>
          </div>

          <div class="card danger">
            <h3>Siswa Pembinaan</h3>
            <p>18</p>
          </div>
        </div>

        <!-- TABLE -->
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Nama</th>
                <th>Kelas</th>
                <th>NISN</th>
                <th>Jurusan</th>
                <th>Jenis Pelanggaran</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Budi Santoso</td>
                <td>X DKV 5</td>
                <td>1234567890</td>
                <td>IPA</td>
                <td>Terlambat</td>
                <td><span class="status warning">Pembinaan</span></td>
              </tr>

              <tr>
                <td>Siti Aminah</td>
                <td>XI RPL 7</td>
                <td>9876543210</td>
                <td>RPL</td>
                <td>Tidak memakai atribut</td>
                <td><span class="status done">Selesai</span></td>
              </tr>
            </tbody>
          </table>
        </div>
      </section>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="{{ asset('js/admin/riwayat.js') }}"></script>
@endpush

</body>
</html>