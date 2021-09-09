<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Question;
class QuestionController extends Controller
{
    public function index(){
        $questions = Question::paginate(25);
        return view('admin.questions.index', compact('questions'));
    }
    public function show(Question $question){
        $question->read = 1;
        $question->save();
        return view('admin.questions.show', compact('question'));
    }
    public function destroy(Question $question){
        $question->delete();
        session()->flash('success', 'Вопрос удален');
        return redirect()->route('admin.questions.index');
    }
    public function reply(Request $request, Question $question){
        $request->validate([
            'text' => 'required|string'
        ]);
        $text = $request->text;
        $question->reply = $text;
        $question->save();
        session()->flash('success', 'Письмо с ответом успешно отправлено на адрес ' . $question->email);
        return back();
    }
}
