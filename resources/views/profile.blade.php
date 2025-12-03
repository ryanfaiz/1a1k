@extends('layout.main')

@section('content')
    <h3 class="mb-4">Profil Saya</h3>

    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center gap-3 mb-3">
                @php $user = auth()->user(); @endphp
                <div style="width:96px;height:96px;overflow:hidden;border-radius:50%;background:#f0f0f0;display:flex;align-items:center;justify-content:center;">
                    @if($user->avatar)
                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="avatar" style="width:100%;height:100%;object-fit:cover;" />
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=256&background=DDDDDD&color=333333" alt="avatar" style="width:100%;height:100%;object-fit:cover;" />
                    @endif
                </div>

                <div>
                    <p class="mb-0"><strong>Nama:</strong> {{ $user->name }}</p>
                    <p class="mb-0"><strong>Email:</strong> {{ $user->email }}</p>
                    @if($user->bio)
                        <p class="mt-2 small text-muted">{{ $user->bio }}</p>
                    @else
                        <p class="mt-2 small text-muted">Belum menambahkan bio.</p>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="avatar" class="form-label">Ganti Foto Profil (opsional)</label>
                    <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*">
                    @error('avatar')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Bio (opsional)</label>
                    <textarea name="bio" id="bio" class="form-control" rows="4" maxlength="1000">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
            </form>
        </div>
    </div>
@endsection
