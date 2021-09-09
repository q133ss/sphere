<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\ScheduleUpdate;
use App\Event;
use Carbon\Carbon;
class ScheduleController extends Controller
{
    public function index(Request $request){
        if($request->wantsJson()){
            $start = Carbon::parse($request->date)->format('Y-m-d');
            $end = Carbon::parse($request->date)->add(2, 'days')->format('Y-m-d');
            $events = Event::with(['student:id,name', 'teacher:id,name', 'subject'])
                ->where('teacher_id', auth()->id())
                ->whereDate('start', '>=', $start)
                ->whereDate('end', '<=', $end)
                ->orderBy('start')
                ->get();
            return $events->groupBy(function($item){
                return $item->start->format('d.m.Y');
            });
        }
        return view('teacher.schedule');
    }
    public function store(Request $request){
        $request->validate([
            'start' => 'required|date',
            'subject_id' => 'required|numeric'
        ]);
        $teacher_id = auth()->id();
        $start = Carbon::parse($request->start);
        $data = [
            'start' => $start->toDatetimeString(),
            'end' => Carbon::parse($start)->add(1, 'hours')->toDatetimeString(),
            'teacher_id' => $teacher_id,
            'subject_id' => $request->subject_id
        ];
        $events = [$data];
        if($request->repeat){
            $end = Carbon::parse($request->repeatEnd);
            while($start->isBefore($end)){
                $data['start'] = $start->add(1, 'days')->toDateTimeString();
                $data['end'] = Carbon::parse($start)->add(1, 'hours')->toDatetimeString();
                $events[] = $data;
            }
        }
        Event::insert($events);
        broadcast(new ScheduleUpdate($teacher_id))->toOthers();
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
