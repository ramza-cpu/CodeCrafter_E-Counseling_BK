@extends('layouts.app')

@section('title', 'Cetak')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/manajemen.css') }}">
@endpush

@section('content')
            <!-- Mobile Topbar -->
            <div class="mobile-topbar">
                <button class="mobile-hamburger" id="mobileHamburger" type="button">
                    ☰
                </button>
                <h2 class="mobile-logo">Smart E-Counsel</h2>
            </div>

            <!-- MAIN CONTENT -->
            <section class="main-content">
                <h1>Manajemen Data Siswa</h1>

                <!-- Action Bar -->
                <div class="action-bar">
                    <button class="btn btn-primary" id="btnTambahSiswa">
                        <i class="fas fa-plus"></i> Tambah Siswa
                    </button>
                    
                    <div class="search-filter">
<form method="GET" action="{{ route('admin.manajemen') }}">
<div class="search-box">
    <i class="fas fa-search"></i>
    <input type="text" name="search" placeholder="Cari nama siswa..." value="{{ request('search') }}">
</div>
</form>
                        
                        <select id="filterKelas" class="filter-select">
                            <option value="">Semua Kelas</option>
                            <option value="X">Kelas X</option>
                            <option value="XI">Kelas XI</option>
                            <option value="XII">Kelas XII</option>
                        </select>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Total Siswa</h3>
                            <p class="stat-number" id="totalSiswa">{{ $totalSiswa }}</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon green">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Kelas X</h3>
                            <p class="stat-number" id="kelasX">{{ $kelasX }}</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon orange">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Kelas XI</h3>
                            <p class="stat-number" id="kelasXI">{{ $kelasXI }}</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon purple">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div class="stat-info">
                            <h3>Kelas XII</h3>
                            <p class="stat-number" id="kelasXII">{{ $kelasXII }}</p>
                        </div>
                    </div>
                </div>

                <!-- Table Card -->
                <div class="table-card">
                    <div class="table-header">
                        <h3>Daftar Siswa</h3>
                        
                    </div>

                    <div class="table-container">
                        <table class="data-table" id="studentTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Skor</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
<tbody>
@foreach($siswa as $data)
<tr>
    <td>{{ $data->id_siswa }}</td>
    <td>{{ $data->user->username }}</td>
    <td>{{ $data->nisn }}</td>
    <td>{{ $data->nama }}</td>
    <td>{{ $data->kelas }}</td>
    <td>{{ $data->jenis_kelamin }}</td>
    <td>{{ $data->alamat }}</td>
    <td>{{ $data->no_hp }}</td>
    <td>{{ $data->skor }}</td>
<td>
<div class="action-buttons">

<button 
class="btn-edit"
data-id="{{ $data->id_siswa }}"
data-username="{{ $data->user->username }}"
data-email="{{ $data->user->email }}"
data-nisn="{{ $data->nisn }}"
data-nama="{{ $data->nama }}"
data-kelas="{{ $data->kelas }}"
data-jk="{{ $data->jenis_kelamin }}"
data-alamat="{{ $data->alamat }}"
data-nohp="{{ $data->no_hp }}"
data-skor="{{ $data->skor }}"
>
<i class="fas fa-edit"></i> Edit
</button>


<button 
class="btn-delete"
data-id="{{ $data->id_siswa }}"
>
<i class="fas fa-trash"></i> Hapus
</button>

</div>
</td>
</tr>
@endforeach
</tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
<div class="mt-4">
    {{ $siswa->links() }}
</div>

            </section>
@endsection
    <!-- Modal Form Siswa -->
    <div class="modal" id="modalSiswa">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Tambah Data Siswa</h2>
                <button class="modal-close" id="closeModal">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <form id="formSiswa" method="POST" action="{{ route('manajemen.store') }}">
                @csrf
                <input type="hidden" id="studentId" name="id_siswa">
                <input type="hidden" name="_method" id="formMethod">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="username">Username <span class="required">*</span></label>
                        <input type="text" id="username" name="username" placeholder="username untuk login siswa" required>
                    </div>

                    <div class="form-group">
                             <label for="email">Email <span class="required">*</span></label>
                            <input type="email" id="email" name="email" required>
                     </div>

                    <div class="form-group">
                        <label for="nisn">NISN <span class="required">*</span></label>
                        <input type="text" id="nisn" name="nisn" pattern="[0-9]+" required>
                    </div>

                    <div class="form-group full-width">
                        <label for="nama">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="nama" name="nama" required>
                    </div>

                    <div class="form-group">
                        <label for="kelas">Kelas <span class="required">*</span></label>
                        <select id="kelas" name="kelas" required>
                            <option value="">Pilih Kelas</option>
                            <option value="X-A">X-A</option>
                            <option value="X-B">X-B</option>
                            <option value="XI-A">XI-A</option>
                            <option value="XI-B">XI-B</option>
                            <option value="XII-A">XII-A</option>
                            <option value="XII-B">XII-B</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin <span class="required">*</span></label>
                        <select id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label for="alamat">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="no_hp">No HP</label>
                        <input type="tel" id="no_hp" name="no_hp">
                    </div>

                    <div class="form-group">
                        <label for="skor">Skor</label>
                        <input type="number" id="skor" name="skor" value="0" min="0">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="btnBatal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@push('scripts')
<script src="{{ asset('js/admin/manajemen.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))

<script>

Swal.fire({

icon:'success',

title:'Berhasil',

text:'{{ session('success') }}'

})

</script>

@endif


@if(session('error'))

<script>

Swal.fire({

icon:'error',

title:'Error',

text:'{{ session('error') }}'

})

</script>


@endif

@if(session('success'))

<script>

Swal.fire({
icon: 'success',
title: 'Berhasil',
text: '{{ session('success') }}'
})

</script>

@endif


@if(session('error'))

<script>

Swal.fire({
icon: 'error',
title: 'Gagal',
text: '{{ session('error') }}'
})

</script>

@endif

@endpush