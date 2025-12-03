@extends('layout.main')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="mb-0">Daftar Materi</h2>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('courses.create') }}" class="btn btn-primary">
                    + Tambah Materi
                </a>
            @endif
        </div>

        @if($courses->isEmpty())
            <div class="alert alert-info">
                Belum ada materi yang ditambahkan.
            </div>
        @else
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Deskripsi</th>
                                <th style="width: 150px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($courses as $course)
                                <tr>
                                    <td>{{ $course->title }}</td>
                                    <td>{{ Str::limit($course->description, 50) }}</td>
                                    <td>
                                        <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-info">Lihat</a>
                                        @if(auth()->user()->role === 'admin')
                                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
