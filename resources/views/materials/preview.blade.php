@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>{{ $material->title }}</h4>
        <a href="{{ route('chapters.show', $material->chapter_id) }}" class="btn btn-secondary">Back</a>
    </div>

    @if($material->description)
        <p class="text-muted mb-4">{{ $material->description }}</p>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            @php
                $ext = pathinfo($material->file_path, PATHINFO_EXTENSION);
            @endphp

            @if(strtolower($ext) === 'pdf')
                <!-- PDF Preview -->
                <iframe src="{{ asset('storage/' . $material->file_path) }}" 
                        width="100%" 
                        height="600px" 
                        style="border: 1px solid #ddd;">
                </iframe>
            @else
                <!-- Non-PDF File -->
                <div class="alert alert-info">
                    <p>File type: <strong>{{ strtoupper($ext) }}</strong></p>
                    <p>This file type cannot be previewed in the browser.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="d-flex gap-2">
        <a href="{{ route('materials.download', $material->id) }}" class="btn btn-primary">
            <i class="bi bi-download"></i> Download File
        </a>
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('materials.edit', $material->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        @endif
    </div>
</div>
@endsection
