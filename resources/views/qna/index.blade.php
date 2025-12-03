@extends('layout.main')

@section('content')
<div class="container mt-4">
    <a href="/" class="btn btn-sm btn-secondary mb-3">← Kembali</a>

    <h2>Daftar Pertanyaan</h2>

    <a href="/qna/create" class="btn btn-primary mb-3">Buat Pertanyaan</a>

    @foreach ($questions as $q)
        <div class="card mb-3 p-3">
            <h3>{{ $q->title }}</h3>

            <p class="text-muted" style="font-size: 14px;">
                Ditanyakan oleh: <strong><a href="{{ route('users.show', $q->user_id) }}">{{ $q->user->name ?? 'User tidak ditemukan' }}</a></strong>  
                • {{ $q->created_at->diffForHumans() }}
            </p>

            <a href="/qna/{{ $q->id }}" class="btn btn-primary btn-sm">
                Lihat detail
            </a>
        </div>
    @endforeach

</div>
@endsection
