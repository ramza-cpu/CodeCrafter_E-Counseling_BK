
       @extends('layouts.app')

@section('title', 'Log Siswa')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/guru/riwayat.css') }}">
@endpush


@section('content')
<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">Smart E-Counsel</h2>
</div>
      <!-- MAIN CONTENT -->
      <section class="main-content">
        <h1>Log Aktifitas Murid</h1>

        <!-- TOP BAR -->
<form method="GET">
<div class="top-bar">

  <div class="search-box">
    <input 
      type="text" 
      name="search"
      value=""
      placeholder="Cari nama..."
    />
  </div>

  <div class="card total">
    <h3>Total Pelanggaran</h3>
    <p>3</p>
  </div>

  <div class="card danger">
    <h3>Siswa Pembinaan</h3>
    <p>0</p>
  </div>

</div>


        <!-- TABLE -->
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Keterangan</th>
                <th>tanggal</th>
              </tr>
            </thead>
<tbody>
<tr>
    <td>21</td>
    <td>Betania Agustina</td>
    <td>X-C</td>
    <td>Membolos pelajaran</td>
    <td>20</td>
    <td>tidak masuk kelas pada jam pelajaran</td>
    <td>2026-03-10 16:00:24</td>
</tr>
<tr>
    <td>20</td>
    <td>Ina Aryani</td>
    <td>X-A</td>
    <td>Terlambat masuk sekolah</td>
    <td>17</td>
    <td>datang ke sekolah pada pukul 07:15</td>
    <td>2026-03-10 15:59:32</td>
</tr>
<tr>
    <td>19</td>
    <td>Yono Suryono</td>
    <td>X-C</td>
    <td>Tidak memakai atribut lengkap</td>
    <td>16</td>
    <td>tidak memakai bet jurusan</td>
    <td>2026-03-10 15:58:28</td>
</tr>
</tbody>
          </table>
        </div>
<div class="pagination-custom pagination">
    
</div>
      </section>

@endsection

@push('scripts')
<script src="{{ asset('js/guru/riwayat.js') }}"></script>
@endpush

</body>
</html>