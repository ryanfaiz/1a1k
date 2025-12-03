@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Daftar Semua Material</h2>
    </div>

    @if($materials->isEmpty())
        <div class="alert alert-info">
            Belum ada material yang ditambahkan.
        </div>
    @else
        <div class="card">
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Chapter</th>
                            <th>Course</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($materials as $material)
                            <tr>
                                <td>{{ $material->title }}</td>
                                <td>{{ Str::limit($material->description ?? '-', 50) }}</td>
                                <td>
                                    <a href="{{ route('chapters.show', $material->chapter->id) }}" class="text-decoration-none">
                                        {{ $material->chapter->title }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('courses.show', $material->chapter->course->id) }}" class="text-decoration-none">
                                        {{ $material->chapter->course->title }}
                                    </a>
                                </td>
                                <td>
                                    @if($material->file_path)
                                        <a href="{{ route('materials.preview', $material->id) }}" class="btn btn-sm btn-primary">View</a>
                                    @endif
                                    <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $materials->links() }}
        </div>
    @endif
</div>
@endsection
