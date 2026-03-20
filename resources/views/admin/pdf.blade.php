<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PDF</title>
    </head>
    <body>
        <h2 style="text-align:center">KOP SEKOLAH</h2>
        <hr>
        
        <p>Nama: {{ $surat->nama }}</p>
        <p>Kelas: {{ $surat->kelas }}</p>
        
        <br>
        
        <p>{{ $isi }}</p>
        
        <br><br>
        
        <p style="text-align:right">
        Guru BK<br><br><br>
        ( {{ auth()->user()->name }} )
        </p>
        
        </body>
        </html>