@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-body">
            <h3 class="mb-3">Edit Jawaban</h3>

            <form action="{{ route('answer.update', $answer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Jawaban</label>
                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" rows="5" required>{{ old('content', $answer->content) }}</textarea>
                    @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Jawaban</button>
                    <a href="{{ route('qna.show', $answer->question_id) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
