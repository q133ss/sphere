<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\TeacherScheduleEvent;
use App\Event;
use Carbon\Carbon;
class ScheduleController extends Controller
{
    public function index(Request $request){
        if($request->wantsJson()){
            $events = Event::with(['student:id,name', 'teacher:id,name', 'subject'])
                ->where('teacher_id', auth()->id())
                ->where('start', '>=', $request->start)
                ->where('end', '<=', $request->end)
                ->get();
            return $events;
        }
        return view('teacher.schedule');
    }
    public function store(Request $request){
        $request->validate([
            'start' => 'required|date',
            'end' => 'required|date'
        ]);
        $events = [];
        $start = Carbon::parse($request->start);
        $end = Carbon::parse($request->end);
        $teacher_id = auth()->id();
        $diff = $end->diffInHours($start);
        while($diff--){
            $event = Event::create([
                'teacher_id' => $teacher_id,
                'start' => $start->format('Y-m-d H:i:00'),
                'end' => $start->addHour()->format('Y-m-d H:i:00')
            ]);
            $event->student = null;
            $event->subject = null;
            $event->load(['teacher:id,name']);
            $events[] = $event;
        }
        broadcast(new TeacherScheduleEvent($teacher_id, 'store', $events))->toOthers();
        return $events;
    }
    public function update(Request $request, $id){
        $event = Event::findOrFail($id);
        $request->validate([
            'end' => 'nullable|date',
            'start' => 'nullable|date'
        ]);
        $event->update($request->all());
        event(new TeacherScheduleEvent('update', $event));
        $event->load(['student:id,name', 'teacher:id,name', 'subject']);
        return $event;
    }
    public function destroy($id){
        $event = Event::findOrFail($id);
        $event->delete();
    }
}
