<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;

class AnswerController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'question_id' => 'required',
            'content' => 'required',
        ]);

        Answer::create([
            'question_id' => $request->question_id,
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back();
    }

    public function edit(Answer $answer)
    {
        if (auth()->id() !== $answer->user_id) {
            abort(403, 'Unauthorized');
        }
        return view('qna.answer-edit', compact('answer'));
    }

    public function update(Request $request, Answer $answer)
    {
        if (auth()->id() !== $answer->user_id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'content' => 'required',
        ]);

        $answer->update([
            'content' => $request->content,
        ]);

        return redirect()->route('qna.show', $answer->question_id)->with('success', 'Answer updated successfully');
    }

    public function destroy(Answer $answer)
    {
        if (auth()->id() !== $answer->user_id) {
            abort(403, 'Unauthorized');
        }
        $question_id = $answer->question_id;
        $answer->delete();

        return redirect()->route('qna.show', $question_id)->with('success', 'Answer deleted successfully');
    }
}
