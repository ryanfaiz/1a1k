@extends('layout.main')

@section('content')
<div class="container mt-4">

    <a href="/qna" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

    <div class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <h2>{{ $question->title }}</h2>
                @if(auth()->id() === $question->user_id)
                    <div class="d-flex gap-2">
                        <a href="{{ route('qna.edit', $question->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('qna.destroy', $question->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus pertanyaan ini?')">Delete</button>
                        </form>
                    </div>
                @endif
            </div>

            <p class="text-muted" style="font-size: 14px;">
                Ditanyakan oleh: <strong><a href="{{ route('users.show', $question->user_id) }}">{{ $question->user->name ?? 'User tidak ditemukan' }}</a></strong>  
                • {{ $question->created_at->diffForHumans() }}
            </p>

            <p>{{ $question->content }}</p>
        </div>
    </div>

    <h4>Jawaban</h4>

    @foreach ($question->answers as $ans)
        <div class="card mb-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div style="flex: 1;">
                        {{ $ans->content }}

                        <p class="text-muted" style="font-size: 14px;">
                            Dijawab oleh: <strong><a href="{{ route('users.show', $ans->user_id) }}">{{ $ans->user->name ?? 'User tidak ditemukan' }}</a></strong>
                            • {{ $ans->created_at->diffForHumans() }}
                        </p>
                    </div>
                    @if(auth()->id() === $ans->user_id)
                        <div class="d-flex gap-2 ms-2">
                            <a href="{{ route('answer.edit', $ans->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('answer.destroy', $ans->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus jawaban ini?')">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <hr>

    <h5>Tambah Jawaban</h5>

    <form action="/answer" method="POST">
        @csrf

        <input type="hidden" name="question_id" value="{{ $question->id }}">

        <div class="mb-3">
            <textarea name="content" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
    </form>

</div>
@endsection
