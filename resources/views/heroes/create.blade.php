<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Hero Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600;800&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <style>
        /* TEMA TERANG MONOCHROME */
        body { background-color: #f3f4f6; color: #1f2937; font-family: 'Poppins', sans-serif; }
        h4, h5 { font-family: 'Cinzel', serif; color: #111827; letter-spacing: 1px; font-weight: 800; }
        
        .card { background: #ffffff; border: none; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .card-header { background: transparent; border-bottom: 2px solid #e5e7eb; padding: 25px; }
        
        /* INPUT STYLE */
        .form-control, .form-select {
            background-color: #f9fafb !important;
            border: 1px solid #d1d5db !important;
            color: #111827 !important;
            padding: 12px;
            border-radius: 8px;
            height: 50px !important; 
        }
        .form-control:focus { background-color: #ffffff !important; border-color: #111827 !important; box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1); }
        input[type="file"].form-control { height: auto !important; }
        label { color: #4b5563; font-weight: 600; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; display: block; }

        /* SELECT2 STYLE */
        .select2-container .select2-selection--multiple {
            background-color: #f9fafb;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            min-height: 50px !important;
            display: flex !important; align-items: center !important; flex-wrap: wrap !important;
            padding: 4px 8px; gap: 6px; cursor: pointer !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #ffffff !important; border: 1px solid #d1d5db !important; color: #000000 !important;
            border-radius: 6px; padding: 0; padding-left: 28px !important; padding-right: 12px !important; height: 34px;
            display: inline-flex !important; align-items: center !important; position: relative; margin: 0 !important;
            font-size: 0.85rem; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            position: absolute !important; left: 0 !important; top: 0 !important; bottom: 0 !important; width: 26px !important;
            height: 100% !important; display: flex !important; align-items: center !important; justify-content: center !important;
            color: #ef4444 !important; font-weight: bold; border-right: 1px solid #e5e7eb; margin-right: 0 !important;
            background: transparent !important;
        }
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            background-color: #fef2f2 !important; color: #dc2626 !important;
        }
        .select2-search__field { width: 0.5em !important; color: transparent !important; caret-color: transparent !important; cursor: pointer !important; }
        .select2-selection__choice img { border-radius: 4px; margin-right: 8px; height: 22px; width: 22px; object-fit: contain; }
        .select2-dropdown { border: 1px solid #d1d5db; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); }
        .select2-results__option { padding: 10px; color: #1f2937; }
        .select2-container--default .select2-results__option--highlighted[aria-selected] { background-color: #f3f4f6; color: black; }
        
        /* SUMMERNOTE STYLE */
        .note-editor { border-color: #d1d5db !important; background: #fff; }
        .note-toolbar { background-color: #f3f4f6 !important; border-bottom: 1px solid #d1d5db !important; }
        .note-btn { color: #374151 !important; }
        
        /* BUTTON STYLE */
        .btn-primary { background-color: #111827; color: white; border: none; font-weight: bold; padding: 10px 24px; border-radius: 8px; }
        .btn-primary:hover { background-color: #000; }
        .btn-outline-secondary { color: #4b5563; border-color: #d1d5db; padding: 10px 24px; border-radius: 8px; }
        .btn-outline-secondary:hover { background-color: #f3f4f6; color: #111827; }
    </style>
</head>
<body class="py-5">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-header">
                    <h4>Buat Hero Baru</h4>
                </div>
                <div class="card-body p-5">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 small">@foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
                        </div>
                    @endif

                    <form action="{{ route('heroes.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-5">
                            <div class="col-md-5">
                                <h5 class="mb-4 border-bottom pb-2" style="border-color: #e5e7eb !important;">Identitas Hero</h5>
                                
                                <div class="mb-4">
                                    <label>Nama Hero</label>
                                    <input type="text" name="name" class="form-control" placeholder="Contoh: Gusion" required>
                                </div>

                                <div class="mb-4">
                                    <label>Foto Potret</label>
                                    <input type="file" name="photo" class="form-control" accept="image/*" required>
                                    <div class="form-text mt-2">Format: JPG, PNG (Max 2MB). Gunakan rasio Portrait.</div>
                                </div>

                                <div class="mb-4">
                                    <label>Role (Kelas)</label>
                                    <select name="roles[]" class="form-control select2-img" multiple="multiple" required>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" data-image="{{ asset($role->image) }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label>Posisi / Lane</label>
                                    <select name="positions[]" class="form-control select2-img" multiple="multiple" required>
                                        @foreach($positions as $pos)
                                            <option value="{{ $pos->id }}" data-image="{{ asset($pos->image) }}">{{ $pos->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <h5 class="mb-4 border-bottom pb-2" style="border-color: #e5e7eb !important;">Atribut & Kisah</h5>

                                <div class="mb-4">
                                    <label>Rekomendasi Build (Maksimal 6)</label>
                                    <select name="items[]" id="itemSelector" class="form-control select2-img" multiple="multiple" required>
                                        @foreach($items as $item)
                                            <option value="{{ $item->id }}" data-image="{{ asset($item->image) }}">
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label>Kisah / Lore</label>
                                    <textarea name="story" id="summernote" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mt-5 pt-4 border-top justify-content-end" style="border-color: #e5e7eb !important;">
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Simpan Hero</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // REVISI TINGGI EDITOR JADI 350px BIAR SEJAJAR
        $('#summernote').summernote({
            placeholder: 'Tulis legenda hero disini...',
            tabsize: 2,
            height: 350, 
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });

        function formatState (opt) {
            if (!opt.id) { return opt.text; }
            var imageUrl = $(opt.element).data('image'); 
            if(!imageUrl){ return opt.text; } 
            return $('<span><img src="' + imageUrl + '" style="width:20px; height:20px; margin-right:8px; border-radius:3px; object-fit:contain;" /> ' + opt.text + '</span>');
        };

        var select2Config = { 
            width: '100%', 
            templateResult: formatState, 
            templateSelection: formatState,
            minimumResultsForSearch: Infinity 
        };

        $('.select2-img').select2(select2Config);
        $('#itemSelector').select2(select2Config);

        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').blur();
        });
        $('.select2-search__field').prop('readonly', true);
    });
</script>

</body>
</html>