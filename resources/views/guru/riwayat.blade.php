
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
@foreach($riwayat as $data)
<tr>
    <td>{{ $data->id_pelanggaran }}</td>
    <td>{{ $data->siswa->nama }}</td>
    <td>{{ $data->siswa->kelas }}</td>
    <td>{{ $data->jenisPelanggaran->nama_pelanggaran }}</td>
    <td>{{ $data->poin }}</td>
    <td>{{ $data->keterangan }}</td>
    <td>{{ $data->tanggal }}</td>

    @endforeach
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