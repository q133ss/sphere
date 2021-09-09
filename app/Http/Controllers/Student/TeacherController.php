<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Event;
use App\Lesson;
use App\Payment;
use App\Events\UserNotificationEvent;
use App\Events\ScheduleUpdate;
use App\Subject;
use Carbon\Carbon;
class TeacherController extends Controller
{
    public function index(Request $request){
        if($request->wantsJson()){
            $teachers = User::with('subjects')->whereRoleId(3)->whereActive(1)->whereConfirmed(1)->paginate(25);
            return $teachers;
        }
        $myTeachers = auth()->user()->teachers->map(function($item){ return $item->id;});
        $subjects = Subject::all();
        return view('student.teachers.index', compact('myTeachers', 'subjects'));
    }
    public function show($id){
        $teacher = User::with(['subjects'])->findOrfail($id);
        return view('student.teachers.show', compact('teacher'));
    }
    public function getSchedule(Request $request, $tid){
        $start = Carbon::parse($request->date)->format('Y-m-d');
        $sid = auth()->id();
        return Event::with(['student:id,name', 'teacher:id,name', 'subject', 'lesson:id,status'])
            ->where('teacher_id', $tid)
            ->whereDate('start', $start)
            ->where(function($query) use ($sid) {
                $query->whereNull('student_id')
                ->orWhere('student_id', $sid);
            })
            ->orderBy('start')
            ->get();
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
        $user = auth()->user();
        $user->decrement('balance', $teacher->lesson_price);
        $user->save();
        if(!$user->teachers->contains($id))
            $user->teachers()->attach($id, [
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
            'end' => $event->end,
            'price' => $teacher->lesson_price
        ]);
        event(new UserNotificationEvent($id, 'У вас появился новый ученик'));
        event(new ScheduleUpdate($id));
        return $user->balance;
    }
    public function unsubscribe(Request $request, $id){
        $teacher = User::findOrFail($id);
        $event = Event::findOrFail($request->id);
        $event->student_id = null;
        $event->save();
        $lesson = $event->lesson;
        $user = auth()->user();
        $user->increment('balance', $lesson->price);
        $lesson->delete();
        event(new UserNotificationEvent($id, 'У вас отменен урок ' . $event->start));
        event(new ScheduleUpdate($id));
        return $user->balance;
    }
}
