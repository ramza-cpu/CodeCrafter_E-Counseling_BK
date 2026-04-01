
       @extends('layouts.app')

@section('title', 'Log Siswa')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/siswa/riwayat.css') }}">
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

<div class="top-bar">


  <div class="card total">
    <h3>Total Pelanggaran</h3>
    <p>{{ $totalPelanggaran }}</p>
  </div>

  <div class="card danger">
    <h3>Skor</h3>
     <p>{{ $siswa->skor }}</p>
  </div>


</div>


        <!-- TABLE -->
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Jenis Pelanggaran</th>
                <th>Poin</th>
                <th>Keterangan</th>
                <th>tanggal</th>
              </tr>
            </thead>
  <tbody>
        @forelse ($riwayat as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                {{-- Nama siswa --}}
                <td>{{ $item->siswa->nama ?? '-' }}</td>

                {{-- Jenis pelanggaran --}}
                <td>{{ $item->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>

                {{-- Poin --}}
                <td>{{ $item->poin }}</td>

                {{-- Keterangan --}}
                <td>{{ $item->keterangan ?? '-' }}</td>

                {{-- Tanggal --}}
                <td>{{ $item->tanggal }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">Tidak ada data pelanggaran</td>
            </tr>
        @endforelse
    </tbody>
          </table>
        </div>
<div class="pagination-custom pagination">
    
</div>
      </section>

@endsection

@push('scripts')
<script src="{{ asset('js/siswa/riwayat.js') }}"></script>
@endpush

</body>
</html>