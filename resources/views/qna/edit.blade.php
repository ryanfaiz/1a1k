@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">Edit Pertanyaan</h3>

            <form action="{{ route('qna.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $question->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Pertanyaan</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content', $question->content) }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Pertanyaan</button>
                    <a href="{{ route('qna.show', $question->id) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
