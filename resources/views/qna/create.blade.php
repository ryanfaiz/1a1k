@extends('layout.main')

@section('content')
<div class="container mt-4">
    <a href="/qna" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

    <h2>Buat Pertanyaan</h2>

    <form action="/qna" method="POST">
        @csrf

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Pertanyaan</label>
            <textarea name="content" class="form-control" rows="5" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection
