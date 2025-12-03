@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">Add Material to {{ $chapter->title }}</h4>

            <form action="{{ route('materials.store', $chapter->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Material Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"></textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">File (PDF, DOC, DOCX)</label>
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx">
                    <small class="text-muted">Max size: 10MB</small>
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Upload Material</button>
                    <a href="{{ route('chapters.show', $chapter->id) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
