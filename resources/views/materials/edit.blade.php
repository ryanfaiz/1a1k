@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">Edit Material</h4>

            <form action="{{ route('materials.update', $material->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Material Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $material->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description', $material->description) }}</textarea>
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">File (PDF, DOC, DOCX)</label>
                    @if($material->file_path)
                        <p class="text-muted"><small>Current file: {{ basename($material->file_path) }}</small></p>
                    @endif
                    <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf,.doc,.docx">
                    <small class="text-muted">Max size: 10MB. Leave empty to keep current file.</small>
                    @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Material</button>
                    <a href="{{ route('chapters.show', $material->chapter_id) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>

            <form action="{{ route('materials.destroy', $material->id) }}" method="POST" style="display:inline;margin-top:12px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus material ini?')">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
