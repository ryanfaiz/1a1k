<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('user')->get();
        return view('qna.index', compact('questions'));
    }

    public function create()
    {
        return view('qna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Question::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect('/qna');
    }

    public function show($id)
    {
        $question = Question::with(['user', 'answers.user'])->findOrFail($id);
        return view('qna.show', compact('question'));
    }

    public function edit(Question $question)
    {
        if (auth()->id() !== $question->user_id) {
            abort(403, 'Unauthorized');
        }
        return view('qna.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        if (auth()->id() !== $question->user_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $question->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('qna.show', $question->id)->with('success', 'Question updated successfully');
    }

    public function destroy(Question $question)
    {
        if (auth()->id() !== $question->user_id) {
            abort(403, 'Unauthorized');
        }
        $question->delete();

        return redirect('/qna')->with('success', 'Question deleted successfully');
    }
}
