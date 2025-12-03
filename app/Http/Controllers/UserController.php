<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Question;
use App\Models\Answer;
use App\Exports\UserQnaExport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can access user management');
        }

        $users = User::orderBy('id', 'asc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Only admins can change roles');
        }

        $request->validate([
            'role' => 'required|in:user,admin'
        ]);

        // Prevent demoting yourself
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'You cannot remove your own admin role');
        }

        $user->role = $request->role;
        $user->save();

        return back()->with('success', 'User role updated');
    }

    public function show(User $user)
    {
        // public profile view: show avatar, bio, counts, and recent q/a
        $questions = $user->questions()->latest()->take(50)->get();
        $answers = $user->answers()->latest()->take(50)->with('question')->get();

        $questionCount = $user->questions()->count();
        $answerCount = $user->answers()->count();

        return view('users.show', compact('user', 'questions', 'answers', 'questionCount', 'answerCount'));
    }

    /**
     * Export user's Q&A as formatted Excel. Allowed for the user themself or admins.
     */
    public function exportCsv(User $user)
    {
        if (!auth()->check() || (auth()->id() !== $user->id && auth()->user()->role !== 'admin')) {
            abort(403, 'Unauthorized');
        }

        $filename = 'user-'.$user->id.'-qna-'.date('Ymd_His').'.xlsx';

        return Excel::download(new UserQnaExport($user), $filename);
    }
}
