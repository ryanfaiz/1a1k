@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">{{ $chapter->title }}</h4>

            <div class="d-flex gap-2 mb-4">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('chapters.edit', $chapter->id) }}" class="btn btn-warning">
                        Edit
                    </a>
                @endif
                <a href="{{ route('courses.show', $chapter->course_id) }}" class="btn btn-secondary">
                    Back to Course
                </a>
            </div>

            <hr class="my-4">

            <h5>Materials</h5>
            <div class="mb-3">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('materials.create', $chapter->id) }}" class="btn btn-success btn-sm">
                        + Add Material
                    </a>
                @endif
            </div>

            @forelse($chapter->materials as $material)
                <div class="border rounded p-3 mb-2 d-flex justify-content-between align-items-center">
                    <div>
                        <h6>{{ $material->title }}</h6>
                        <small class="text-muted">{{ $material->description ?? 'No description' }}</small>
                    </div>
                    <div>
                        @if($material->file_path)
                            <a href="{{ route('materials.preview', $material->id) }}" class="btn btn-sm btn-primary">View</a>
                        @endif
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-muted">No materials yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
