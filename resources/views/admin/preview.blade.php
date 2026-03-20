<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Preview Surat</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: "Times New Roman", serif;
            background: #eaeaea;
            padding: 20px;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: auto;
            background: white;
            padding: 50px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .kop {
            text-align: center;
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .kop h2 {
            margin: 0;
        }

        .nomor {
            margin-top: 10px;
        }

        .judul {
            text-align: center;
            margin: 20px 0;
            font-weight: bold;
            text-decoration: underline;
        }

        .content {
            font-size: 16px;
            line-height: 1.7;
            text-align: justify;
        }

        .data-siswa p {
            margin: 3px 0;
        }

        .pelanggaran {
            margin-top: 10px;
        }

        .ttd {
            margin-top: 80px;
            text-align: right;
        }

        .btn-print {
            margin-top: 30px;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .btn-print {
                display: none;
            }

            .page {
                box-shadow: none;
                margin: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="page">

    <!-- KOP -->
    <div class="kop">
        <h2>SEKOLAH MENENGAH ATAS</h2>
        <p>Jl. Pendidikan No. 123, Indonesia</p>
    </div>

    <!-- NOMOR -->
    <div class="nomor">
        Nomor: {{ $surat->nomor_surat ?? '-' }}
    </div>

    <!-- JUDUL -->
    <div class="judul">
        {{ strtoupper($surat->jenis_surat) }}
    </div>

    <!-- DATA SISWA -->
    <div class="content data-siswa">
        <p>Nama Siswa : <strong>{{ $surat->nama }}</strong></p>
        <p>Kelas : <strong>{{ $surat->kelas }}</strong></p>
        <p>Nama Ayah : {{ $ortu->nama_ayah ?? '-' }}</p>
        <p>Nama Ibu : {{ $ortu->nama_ibu ?? '-' }}</p>
    </div>

    <br>

    <!-- ISI SURAT -->
    <div class="content">
        {!! nl2br(e($isi)) !!}
    </div>

    <!-- PELANGGARAN -->
    <div class="content pelanggaran">
        <strong>Daftar Pelanggaran:</strong>
        <ul>
            @foreach($pelanggaranList as $p)
                <li>{{ $p }}</li>
            @endforeach
        </ul>
    </div>

    <!-- TANGGAL -->
    <div class="content">
        <p>
            Tanggal Cetak: {{ date('d-m-Y') }}
        </p>
    </div>

    <!-- TTD -->
    <div class="ttd">
        <p>Guru BK</p>
        <br><br><br>
        <p><strong>{{ $guru->nama ?? auth()->user()->name }}</strong></p>
    </div>

    <!-- BUTTON -->
    <button class="btn-print" onclick="printSurat({{ $surat->id_surat }})">
        🖨 Cetak Surat
    </button>

</div>

<script>
function printSurat(id) {
    window.print();

    fetch(`/surat/${id}/cetak`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(res => res.json())
    .then(res => {
        console.log(res);
    })
    .catch(err => console.error(err));
}
</script>

</body>
</html>