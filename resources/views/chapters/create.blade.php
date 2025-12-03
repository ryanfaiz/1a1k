@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">Create Chapter</h4>

            <form action="{{ route('chapters.store', $course->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Chapter Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create Chapter</button>
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
