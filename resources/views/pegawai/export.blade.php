<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NRP</th>
            <th>Pangkat</th>
            <th>Jabatan</th>
            <th>Satuan Kerja</th>

            <th>Kinerja Semester 1</th>
            <th>Kinerja Semester 2</th>
            <th>Disiplin</th>
            <th>Rohani Semester 1</th>
            <th>Rohani Semester 2</th>
            <th>E-Mental Semester 1</th>
            <th>E-Mental Semester 2</th>
            <th>Kesehatan</th>
            <th>Jasmani Semester 1</th>
            <th>Jasmani Semester 2</th>
            <th>Akademik</th>
            <th>Nilai IP Personel</th>
            <th>Kategori Nilai IP</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($pegawai as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->nrp }}</td>
                <td>{{ $item->pangkat }}</td>
                <td>{{ $item->jabatan }}</td>
                <td>{{ $item->satuan_kerja }}</td>

                <td>{{ $item->kinerja_semester_1 }}</td>
                <td>{{ $item->kinerja_semester_2 }}</td>
                <td>{{ $item->disiplin }}</td>
                <td>{{ $item->rohani_semester_1 }}</td>
                <td>{{ $item->rohani_semester_2 }}</td>
                <td>{{ $item->emental_semester_1 }}</td>
                <td>{{ $item->emental_semester_2 }}</td>
                <td>{{ $item->kesehatan }}</td>
                <td>{{ $item->jasmani_semester_1 }}</td>
                <td>{{ $item->jasmani_semester_2 }}</td>
                <td>{{ $item->akademik }}</td>
                <td>{{ $item->nilai_ip_personel }}</td>
                <td>{{ $item->kategori_ip }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
