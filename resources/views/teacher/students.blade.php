@extends('layouts.dashboard')
@section('title', 'Мои ученики')

@push('scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        function students_find(query){
            $.ajax({
                url: "{{route('teacher.students.find')}}",
                type: "POST",
                data: {
                    search: query
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('.t-student__info-list-wrapper').html(data)
                },
                error: function(request, status, error) {
                     //alert(statusCode = request.responseText);
                    //console.log(statusCode = request.responseText)
                }
            });
        }
    </script>
@endpush

@section('content')
    <section class="t-student__info">
        <div class="wrappers">
            <div class="t-student__info-list">
                <div class="t-student__info-list-title">Мои ученики</div>
                <div class="t-student__info-list-search">
                    <div class="t-student__info-list-search-icons"> <img src="/v2/svg/t-student/search.svg" alt="search"></div>
                    <input type="text" placeholder="Поиск ..." oninput="students_find($(this).val())" id="teacherStudentSearch">
                    <label for="teacherStudentSearch">Найти ученика</label>
                </div>
                <ul class="t-student__info-list-add">
                    <div class="t-student__info-list-add-items">Ученик</div>
                    <div class="t-student__info-list-add-items">Предмет</div>
                    <div class="t-student__info-list-add-items">Дата</div>
                </ul>
                <chat :auth="{{auth()->user()}}"></chat>
                <ul class="t-student__info-list-wrapper">
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
                </ul>
            </div>
            <div class="t-student__info-chat display-n"><a name="chat"> </a>
                <div class="t-student__info-chat-title">Чат с учеником</div>
                <div class="t-student__info-chat-add">Сообщения</div>
                <div class="t-student__info-chat-wrappers">
                    <div class="t-student__info-chat-message">
                        <div class="t-student__info-chat-message-items">
                            <div class="t-student__info-chat-message-photo"> </div>
                            <div class="t-student__info-chat-message-info">
                                <div class="t-student__info-chat-message-text">Артур, почему опять двойка ?</div>
                                <div class="t-student__info-chat-message-date">3 минуты назад</div>
                            </div>
                        </div>
                        <div class="t-student__info-chat-message-items t-student__info-chat-message-items-you">
                            <div class="t-student__info-chat-message-photo"> </div>
                            <div class="t-student__info-chat-message-info">
                                <div class="t-student__info-chat-message-text">Артур, почему опять двойка ?</div>
                                <div class="t-student__info-chat-message-date">3 минуты назад</div>
                            </div>
                        </div>
                        <div class="t-student__info-chat-message-items t-student__info-chat-message-items-you">
                            <div class="t-student__info-chat-message-photo"> </div>
                            <div class="t-student__info-chat-message-info">
                                <div class="t-student__info-chat-message-text">Артур, почему опять двойка ?</div>
                                <div class="t-student__info-chat-message-date">3 минуты назад</div>
                            </div>
                        </div>
                        <div class="t-student__info-chat-message-items">
                            <div class="t-student__info-chat-message-photo"> </div>
                            <div class="t-student__info-chat-message-info">
                                <div class="t-student__info-chat-message-text">Артур, почему опять двойка ?</div>
                                <div class="t-student__info-chat-message-date">3 минуты назад</div>
                            </div>
                        </div>
                        <div class="t-student__info-chat-message-items">
                            <div class="t-student__info-chat-message-photo"> </div>
                            <div class="t-student__info-chat-message-info">
                                <div class="t-student__info-chat-message-text">Артур, почему опять двойка ?</div>
                                <div class="t-student__info-chat-message-date">3 минуты назад</div>
                            </div>
                        </div>
                        <div class="t-student__info-chat-message-items t-student__info-chat-message-items-you">
                            <div class="t-student__info-chat-message-photo"> </div>
                            <div class="t-student__info-chat-message-info">
                                <div class="t-student__info-chat-message-text">Артур, почему опять двойка ?</div>
                                <div class="t-student__info-chat-message-date">3 минуты назад</div>
                            </div>
                        </div>
                    </div>
                    <div class="t-student__info-chat-controls"><a class="t-student__info-chat-controls-file" type="file"> <img src="/v2/svg/t-student/file.svg" alt="icons"></a>
                        <div class="t-student__info-chat-controls-message">
                            <input type="text" placeholder="Напишите сообщение ...">
                        </div>
                        <div class="t-student__info-chat-controls-small"><img src="/v2/svg/t-student/small.svg" alt="icons"></div>
                        <button class="t-student__info-chat-controls-btn"> <img src="/v2/svg/t-student/messages.svg" alt="icons"></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
