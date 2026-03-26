@extends('layouts.app')

@section('title', 'Cetak')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/cetak.css') }}">
@endpush

@section('content')
<!-- Mobile Topbar -->
<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">{{ config('app.name') }}</h2>
</div>

<section class="main-content">

    <h1>Cetak Laporan</h1>

    <button onclick="window.print()" class="btn-print">
        🖨 Cetak
    </button>

    <div class="print-wrapper">

<div class="print-card">
    <h3>Data Laporan</h3>
    
    <!-- Wrapper untuk horizontal scroll -->
    <div class="table-container">
        <table class="print-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Siswa</th>
                    <th>Nomor Surat</th>
                    <th>Jenis Surat</th>
                    <th>Tanggal Cetak</th>
                    <th>Jenis Pelanggaran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
<tbody>
@foreach($surat as $item)
<tr>
    <td>{{ $item->id_surat }}</td>
    <td>{{ $item->nama }}</td>
    <td>{{ $item->nomor_surat ?? '-' }}</td>
    <td>{{ $item->jenis_surat }}</td>
    <td>{{ $item->tanggal_cetak ?? '-' }}</td>
    <td>{{ $item->jenis_pelanggaran ?? '-' }}</td>

    <td>
        
        <span class="{{ $item->status == 'tercetak' ? 'status-done' : 'status-pending' }}">
            {{ $item->status }}
        </span>
    </td>

    <td>
@if($item->status == 'pending')
    <button onclick="confirmCetak({{ $item->id_surat }})" class="btn-print">
        Cetak
    </button>
@else
    <span>Sudah Dicetak</span>
@endif
    </td>
</tr>
@endforeach
</tbody>
</table>

        </div>

    </div>

</section>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('js/admin/cetak.js') }}"></script>
<script>
function confirmCetak(id) {
    Swal.fire({
        title: "Cetak Surat?",
        text: "Lihat preview dulu sebelum cetak",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Preview",
    }).then((result) => {
        if (result.isConfirmed) {
            window.open(`/surat/${id}/preview`, '_blank');
        }
    });
}
</script>
@endpush