@extends('layout.main')

@section('content')

<div class="row g-3">

    <!-- Introduction -->
    <div class="welcome-card">
            <h1>👋 Selamat Datang di 1ToAsk1ToKnow!</h1>
            <p>Platform pembelajaran interaktif untuk bertanya dan berbagi pengetahuan</p>
        </div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-value">{{ $materiCount }}</div>
                <div class="stat-label">Materi Tersedia</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-value">{{ $userCount }}</div>
                <div class="stat-label">Pengguna Aktif</div>
            </div>
        </div>
</div>
@endsection
