@extends('layouts.app')

@section('title', 'Akumulasi Pelanggaran')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/akumulasi.css') }}">
@endpush

@section('content')

<div class="mobile-topbar">
    <button class="mobile-hamburger" id="mobileHamburger" type="button">
        ☰
    </button>
    <h2 class="mobile-logo">Smart E-Counsel</h2>
</div>


            <section class="main-content">
                <h1>Input Pelanggaran</h1>

                <div class="scan-wrapper">

                    <div class="scan-card">

            <h3>Data Siswa</h3>
            <p><strong>Nama:</strong> {{ $siswa->nama }}</p>
            <p><strong>Kelas:</strong> {{ $siswa->kelas }}</p>
            <p><strong>Skor Saat Ini:</strong> {{ $siswa->skor }}</p>

            <hr>

            <form method="POST" action="{{ route('akumulasi.store') }}">
                @csrf

                <input type="hidden" name="id_siswa" value="{{ $siswa->id_siswa }}">

                <label>Pilih Pelanggaran</label>
<select name="id_jenis_pelanggaran" id="jenisSelect" required>
    <option value="">-- Pilih Pelanggaran --</option>
    @foreach($jenis as $item)
        <option value="{{ $item->id_jenis_pelanggaran }}" data-poin="{{ $item->poin }}">
            {{ $item->nama_pelanggaran }} ({{ $item->poin }} poin)
        </option>
    @endforeach
</select>

                <label>Skor</label>
<input type="number" name="poin" id="poinInput" readonly>

                <label>Keterangan</label>
                <textarea name="keterangan"
                          rows="3"
                          placeholder="Masukkan keterangan pelanggaran"
                          required></textarea>

                <button type="submit" class="btn-primary">
                    Simpan Pelanggaran
                </button>

            </form>

        </div>

    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/admin/akumulasi.js') }}"></script>
@endpush

            <!-- MAIN CONTENT
            <section class="main-content">
                <h1>Input Pelanggaran</h1>

                <div class="scan-wrapper">

                    <div class="scan-card">

                        <h3>Data Siswa</h3>
                        <p><strong>Nama:</strong> Bakiman Irsad Marpaung S.Pt</p>
                        <p><strong>Kelas:</strong> X-A</p>
                        <p><strong>Skor Saat Ini:</strong> 0</p>

                        <hr>

                        <form method="POST" action="/akumulasi/store">
                            <input type="hidden" name="_token" value="token_here" autocomplete="off">
                            <input type="hidden" name="id_siswa" value="10">

                            <label>Pilih Pelanggaran</label>
                            <select name="id_jenis_pelanggaran" id="jenisSelect" required>
                                <option value="">-- Pilih Pelanggaran --</option>
                                <option value="1" data-poin="17">Terlambat masuk sekolah (17 poin)</option>
                                <option value="2" data-poin="11">Tidak memakai atribut lengkap (11 poin)</option>
                                <option value="3" data-poin="18">Membolos pelajaran (18 poin)</option>
                                <option value="4" data-poin="5">Rambut tidak sesuai aturan (5 poin)</option>
                                <option value="5" data-poin="17">Tidak mengerjakan tugas (17 poin)</option>
                                <option value="6" data-poin="7">Berisik di kelas (7 poin)</option>
                                <option value="7" data-poin="7">Menggunakan HP saat pelajaran (7 poin)</option>
                                <option value="8" data-poin="12">Terlambat masuk sekolah (12 poin)</option>
                                <option value="9" data-poin="16">Tidak memakai atribut lengkap (16 poin)</option>
                                <option value="10" data-poin="20">Membolos pelajaran (20 poin)</option>
                                <option value="11" data-poin="19">Rambut tidak sesuai aturan (19 poin)</option>
                                <option value="12" data-poin="10">Tidak mengerjakan tugas (10 poin)</option>
                                <option value="13" data-poin="5">Berisik di kelas (5 poin)</option>
                                <option value="14" data-poin="12">Menggunakan HP saat pelajaran (12 poin)</option>
                                <option value="15" data-poin="7">Terlambat masuk sekolah (7 poin)</option>
                            </select>

                            <label>Skor</label>
                            <input type="number" name="poin" id="poinInput" readonly>

                            <label>Keterangan</label>
                            <textarea name="keterangan"
                                      rows="3"
                                      placeholder="Masukkan keterangan pelanggaran"
                                      required></textarea>

                            <button type="submit" class="btn-primary">
                                Simpan Pelanggaran
                            </button>

                        </form>

                    </div>

                </div>
            </section> -->