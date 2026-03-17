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
<form method="GET" action="{{ route('riwayat') }}">
<div class="top-bar">

  <div class="search-box">
    <input 
      type="text" 
      name="search"
      value="{{ $search }}"
      placeholder="Cari nama..."
    />
  </div>

  <div class="card total">
    <h3>Total Pelanggaran</h3>
    <p>{{ $totalPelanggaran }}</p>
  </div>

  <div class="card danger">
    <h3>Siswa Pembinaan</h3>
    <p>{{ $siswaPembinaan }}</p>
  </div>

</div>
</form>

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
    <th>Tanggal</th>
    <th>Status</th>
    <th>Aksi</th>
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

    <!-- STATUS -->
    <td>
        @if($data->status == 'proses')
            <span class="status status-proses">Proses</span>
        @else
            <span class="status status-selesai">Selesai</span>
        @endif
    </td>

    <!-- AKSI -->
    <td>
        @if($data->status == 'proses')
            <form action="{{ route('riwayat.selesai', $data->id_pelanggaran) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-selesai">
                    ✔ Selesai
                </button>
            </form>
        @else
            <span class="text-muted">Selesai</span>
        @endif
    </td>

</tr>
@endforeach
</tbody>
          </table>
        </div>
<div class="pagination-custom pagination">
    {{ $riwayat->links() }}
</div>
      </section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/admin/riwayat.js') }}"></script>
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}'
});
</script>
@endif
@endpush

</body>
</html>