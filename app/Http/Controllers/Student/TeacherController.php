<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\Lesson;
use App\Payment;
use App\Events\UserNotificationEvent;
use App\Events\TeacherScheduleEvent;
class TeacherController extends Controller
{
    public function index(){
        $teachers = User::whereRoleId(3)->whereActive(1)->whereConfirmed(1)->paginate(25);
        $myTeachers = auth()->user()->teachers->map(function($item){ return $item->id;});
        return view('student.teachers.index', compact('teachers', 'myTeachers'));
    }
    public function show($id){
        $teacher = User::with(['subjects'])->findOrfail($id);
        return view('student.teachers.show', compact('teacher'));
    }
    public function getSchedule(Request $request, $id){
        $events = Event::with(['student:id,name', 'teacher:id,name', 'subject', 'lesson:id,status'])
            ->where('teacher_id', $id)
            ->where('start', '>=', $request->start)
            ->where('end', '<=', $request->end)
            ->get();
        return $events;
    }
    public function my(){
        $teachers = auth()->user()->teachers;
        return view('student.teachers.my', compact('teachers'));
    }
    public function subscribe(Request $request, $id){
        $teacher = User::findOrFail($id);
        $event = Event::findOrFail($request->id);
        $event->student_id = auth()->id();
        $event->subject_id = $request->subject_id;
        $event->save();
        auth()->user()->balance -= $teacher->lesson_price;
        auth()->user()->save();
        auth()->user()->teachers()->attach($id, [
            'subject_id' => $request->subject_id
        ]);
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'amount' => $teacher->lesson_price,
            'type' => 'buy',
            'comment' => 'Оплата урока'
        ]);
        Lesson::create([
            'student_id' => auth()->id(),
            'teacher_id' => $id,
            'subject_id' => $request->subject_id,
            'payment_id' => $payment->id,
            'event_id' => $event->id,
            'start' => $event->start,
            'end' => $event->end
        ]);
        session()->flash('success', 'Вы успешно записались на урок');
        event(new UserNotificationEvent($id, 'У вас появился новый ученик'));
        event(new TeacherScheduleEvent('update', $event));
    }
    public function unsubscribe(Request $request, $id){
        $teacher = User::findOrFail($id);
        $event = Event::findOrFail($request->id);
        $event->student_id = null;
        $event->subject_id = null;
        $event->save();
        auth()->user()->balance += $teacher->lesson_price;
        auth()->user()->save();
        auth()->user()->teachers()->dettach($id);
        $lesson = $event->lesson;
        $lesson->payment->delete();
        session()->flash('success', 'Вы успешно отписались от урока');
        event(new UserNotificationEvent($id, 'У вас отменен урок ' . $event->start));
        event(new TeacherScheduleEvent('update', $event));
    }
}
