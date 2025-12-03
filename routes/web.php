<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
Use App\Http\Controllers\MateriController;
Use App\Http\Controllers\CourseController;
Use App\Http\Controllers\ChapterController;
Use App\Http\Controllers\MaterialController;
Use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;


//Halaman Utama
Route::get('/', [
    HomeController::class, 'index'
]);

// Public user profile (anyone can view)
Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('users.show');

// Authentication
Route::get('/register', [
    RegisterController::class, 'index'
]);

Route::post('/register', [
    RegisterController::class, 'store'
]);

Route::get('/login', [
    LoginController::class, 'index'
])->name('login');

Route::post('/login', [
    LoginController::class, 'authenticate'
]);

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});


// Protected (harus login)
Route::middleware('auth')->group(function() {

    // Profile
    Route::get('/profile', [
        ProfileController::class, 'index'
    ]);
    Route::put('/profile', [
        ProfileController::class, 'update'
    ])->name('profile.update');

    // QnA
    Route::get('/qna', [
        QuestionController::class, 'index'
    ]);
    Route::get('/qna/create', [
        QuestionController::class, 'create'
    ]);
    Route::post('/qna', [
        QuestionController::class, 'store'
    ]);
    Route::get('/qna/{question}', [
        QuestionController::class, 'show'
    ])->name('qna.show');
    Route::get('/qna/{question}/edit', [
        QuestionController::class, 'edit'
    ])->name('qna.edit');
    Route::put('/qna/{question}', [
        QuestionController::class, 'update'
    ])->name('qna.update');
    Route::delete('/qna/{question}', [
        QuestionController::class, 'destroy'
    ])->name('qna.destroy');

    Route::post('/answer', [
        AnswerController::class, 'store'
    ]);
    Route::get('/answer/{answer}/edit', [
        AnswerController::class, 'edit'
    ])->name('answer.edit');
    Route::put('/answer/{answer}', [
        AnswerController::class, 'update'
    ])->name('answer.update');
    Route::delete('/answer/{answer}', [
        AnswerController::class, 'destroy'
    ])->name('answer.destroy');

    // Materi
    Route::get('/materi', [
        MateriController::class, 'index'
    ])->name('materi.index');

    // Admin - user management
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::put('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
    // Export user data (CSV) - allowed for user themself or admins
    Route::get('/users/{user}/export', [UserController::class, 'exportCsv'])->name('users.export');

    // Course
    Route::resource('courses', CourseController::class);
    
    Route::post('/courses', [
        CourseController::class, 'store'
    ])->name('courses.store');

    // Chapter
    Route::get('/courses/{course}/chapters/create', [
        ChapterController::class, 'create'
    ])->name('chapters.create');

    Route::post('/courses/{course}/chapters', [
        ChapterController::class, 'store'
    ])->name('chapters.store');

    Route::get('/chapters/{chapter}', [
        ChapterController::class, 'show'
    ])->name('chapters.show');

    Route::get('/chapters/{chapter}/edit', [
        ChapterController::class, 'edit'
    ])->name('chapters.edit');

    Route::put('/chapters/{chapter}', [
        ChapterController::class, 'update'
    ])->name('chapters.update');

    Route::delete('/chapters/{chapter}', [
        ChapterController::class, 'destroy'
    ])->name('chapters.destroy');

    // Material
    Route::get('/chapters/{chapter}/materials/create', [
        MaterialController::class, 'create'
    ])->name('materials.create');

    Route::post('/chapters/{chapter}/materials', [
        MaterialController::class, 'store'
    ])->name('materials.store');

    Route::get('/materials/{material}/preview', [
        MaterialController::class, 'preview'
    ])->name('materials.preview');

    Route::get('/materials/{material}/download', [
        MaterialController::class, 'download'
    ])->name('materials.download');

    Route::get('/materials/{material}/edit', [
        MaterialController::class, 'edit'
    ])->name('materials.edit');

    Route::put('/materials/{material}', [
        MaterialController::class, 'update'
    ])->name('materials.update');

    Route::delete('/materials/{material}', [
        MaterialController::class, 'destroy'
    ])->name('materials.destroy');

    Route::get('/chapters/{chapter}/materials/pdf', [MaterialController::class, 'exportPdf'])
    ->name('materials.pdf');
});
