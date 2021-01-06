<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\TeacherScheduleEvent;
use App\Event;
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
        $event = Event::create([
            'teacher_id' => auth()->id(),
            'start' => $request->start,
            'end' => $request->end
        ]);
        event(new TeacherScheduleEvent('store', $event));
        $event->load(['student:id,name', 'teacher:id,name', 'subject']);
        return $event;
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
        event(new TeacherScheduleEvent('destroy', $event));
        $event->delete();
    }
}
