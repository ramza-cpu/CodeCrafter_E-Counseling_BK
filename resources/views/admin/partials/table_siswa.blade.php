@forelse($siswa as $data)
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
@empty
<tr>
    <td colspan="10" class="text-center">Data tidak ditemukan</td>
</tr>
@endforelse