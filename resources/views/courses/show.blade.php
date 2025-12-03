@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">{{ $course->title }}</h4>

            <p class="mb-4">{{ $course->description }}</p>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('chapters.create', $course->id) }}" class="btn btn-success">
                    Add Chapter
                </a>

                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning ms-2">
                    Edit
                </a>
            @endif

            <a href="{{ route('courses.index') }}" class="btn btn-secondary ms-2">
                Back
            </a>

            <hr class="my-4">

            <h5>Chapters</h5>
            @forelse($course->chapters as $chapter)
                <div class="border rounded p-3 mb-2">
                    <a href="{{ route('chapters.show', $chapter->id) }}" class="text-decoration-none">
                        {{ $chapter->title }}
                    </a>
                </div>
            @empty
                <p>No chapters yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
