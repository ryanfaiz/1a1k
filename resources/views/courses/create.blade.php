@extends('layout.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-3">Create Course</h4>

            <form action="{{ route('courses.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Course Title</label>
                    <input type="text" name="title" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Create Course</button>
            </form>
        </div>
    </div>
</div>
@endsection
