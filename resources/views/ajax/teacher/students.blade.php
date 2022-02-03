@foreach($students as $student)
    <li>
        <a class="t-student__info-list-items" href="#chat">
            <div class="t-student__info-list-items-photo"> </div>
            <div class="t-student__info-list-items-name">{{$student->name}}</div>
            <div class="t-student__info-list-items-lessons">
                @php
                    $subject_get = DB::table('student_teacher')
                                ->select('subject_id')
                                ->where('student_id', $student->id)
                                ->first();
                    $subject_name = App\Subject::find($subject_get->subject_id)['name'];
                @endphp
                {{$subject_name}}
            </div>
            <div class="t-student__info-list-items-date">Зачем тут дата?</div>
        </a>
    </li>
@endforeach
