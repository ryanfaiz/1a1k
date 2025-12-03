<h2>Daftar Materi - {{ $chapter->title }}</h2>

<table width="100%" border="1" cellspacing="0" cellpadding="4">
    <tr>
        <th>No</th>
        <th>Judul</th>
    </tr>

    @foreach ($materials as $m)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $m->title }}</td>
    </tr>
    @endforeach
</table>
