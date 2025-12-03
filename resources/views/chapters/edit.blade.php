@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">Edit Chapter</h4>

            <form action="{{ route('chapters.update', $chapter->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Chapter Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $chapter->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Chapter</button>
                    <a href="{{ route('chapters.show', $chapter->id) }}" class="btn btn-secondary">Cancel</a>
                    <form action="{{ route('chapters.destroy', $chapter->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus chapter ini?')">Delete</button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
