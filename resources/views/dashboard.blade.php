<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Wiki Legend') }}
            </h2>

            <div class="flex gap-2 w-full md:w-auto justify-end">
                <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                    <input type="text" name="search" placeholder="Cari Hero..." value="{{ request('search') }}" 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full md:w-64">
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition">
                        Cari
                    </button>
                </form>
                
                @auth
                    <a href="{{ route('heroes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition whitespace-nowrap font-bold flex items-center" style="text-decoration: none;">
                        + Baru
                    </a>
                @endauth
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 shadow-sm" role="alert">
                    <strong class="font-bold">Berhasil!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <!-- START: Bagian About Web yang Baru -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-8 p-6 lg:p-8 border-t-4 border-blue-600">
                <h3 class="text-2xl font-extrabold text-gray-900 mb-4 border-b pb-2">
                    Tentang Wiki Legend: Fanbase Mobile Legends: Bang Bang.
                </h3>
                <p class="text-gray-700 leading-relaxed mb-4">
                    Selamat datang di Wiki Legend, pusat informasi untuk para penggemar Mobile Legends: Bang Bang.
                    Wiki ini dibuat sebagai ruang komunitas yang menyajikan berbagai data, trivia, serta pembahasan lengkap mengenai hero, lore, item, role, dan update terbaru MLBB.
                    Tujuan utama Wiki Legend adalah membantu pemain, baik pemula maupun veteran, memahami gameplay, meta, dan perkembangan dunia MLBB. Semua konten disusun secara sederhana, terstruktur, dan mudah dijelajahi demi kenyamanan membaca.
                    Wiki Legend dikembangkan oleh komunitas penggemar yang berkomitmen menghadirkan sumber informasi terpercaya dan selalu diperbarui. Setiap artikel dibuat dengan semangat berbagi, belajar, dan merayakan dunia MLBB bersama-sama.
                </p>
            </div>
            <!-- END: Bagian About Web yang Baru -->

            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                @foreach ($heroes as $hero)
                <!-- Card Container dengan efek hover naik (-translate-y-2) -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 relative group border border-gray-100">
                    
                    <!-- TOMBOL ADMIN (Hanya muncul jika login, posisi Pojok Kanan Atas) -->
                    @auth
                    <div class="absolute top-2 right-2 z-20 flex gap-2 opacity-0 group-hover:opacity-100 transition duration-300">
                        <!-- Tombol Edit (Pensil) -->
                        <a href="{{ route('heroes.edit', $hero->id) }}" class="bg-yellow-400 text-white p-2 rounded-full hover:bg-yellow-500 shadow-md transition" title="Edit Hero">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </a>

                        <!-- Tombol Hapus (X) -->
                        <form id="delete-form-{{ $hero->id }}" action="{{ route('heroes.destroy', $hero->id) }}" method="POST">
                            @csrf 
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('{{ $hero->id }}', '{{ $hero->name }}')" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 shadow-md transition" title="Hapus Hero">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @endauth

                    <!-- Gambar Hero (Bisa diklik menuju detail) -->
                    <a href="{{ route('heroes.show', $hero->id) }}" class="block relative h-64 w-full bg-gray-200">
                        @if($hero->photo)
                            <img src="{{ asset('storage/' . $hero->photo) }}" class="w-full h-full object-cover object-top" alt="{{ $hero->name }}">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-400">No Photo</div>
                        @endif
                        <!-- Overlay Hitam dihapus agar bersih -->
                    </a>

                    <!-- Informasi Nama & Role -->
                    <div class="px-3 pt-3 pb-6 text-center bg-white relative z-10 border-t">
                        <a href="{{ route('heroes.show', $hero->id) }}" class="hover:text-blue-600 transition">
                            <h3 class="text-md font-bold text-gray-800 truncate">{{ $hero->name }}</h3>
                        </a>
                        <div class="mt-2 flex flex-wrap justify-center gap-1">
                            @foreach($hero->roles->take(2) as $role)
                                <span class="bg-gray-100 text-gray-800 text-[10px] uppercase font-bold px-2 py-1 rounded border border-gray-200">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                </div>
                @endforeach
            </div>

            @if($heroes->isEmpty())
                <div class="text-center py-12 bg-white rounded-lg shadow-sm border border-dashed border-gray-300 mt-6">
                    <div class="flex flex-col items-center justify-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        @if(request('search'))
                            <p class="text-lg">
                                Hero dengan nama <strong>"{{ request('search') }}"</strong> tidak ditemukan.
                            </p>
                            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline mt-2 text-sm">Reset Pencarian</a>
                        
                        @elseif(request('role'))
                            <p class="text-lg">
                                Belum ada Hero dengan Role <strong>{{ request('role') }}</strong>.
                            </p>
                            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline mt-2 text-sm">Lihat Semua Hero</a>

                        @elseif(request('lane'))
                            <p class="text-lg">
                                Belum ada Hero untuk posisi <strong>{{ request('lane') }}</strong>.
                            </p>
                            <a href="{{ route('dashboard') }}" class="text-blue-500 hover:underline mt-2 text-sm">Lihat Semua Hero</a>

                        @else
                            <p class="text-lg mb-2">Belum ada data Hero di database.</p>
                            @auth
                                <p class="text-sm text-gray-400 mb-4">Jadilah yang pertama menambahkan hero!</p>
                                <a href="{{ route('heroes.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition text-sm">
                                    + Tambah Hero Baru
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            @endif

            <div class="mt-6">
                {{ $heroes->links() }}
            </div>

        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete(heroId, heroName) {
        Swal.fire({
            title: 'Hapus Hero ' + heroName + '?',
            text: "Data ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#fff',
            borderRadius: '10px'
        }).then((result) => {
            if (result.isConfirmed) {
                // Find the specific form for THIS hero and submit it
                document.getElementById('delete-form-' + heroId).submit();
            }
        })
    }
</script>
</x-app-layout>