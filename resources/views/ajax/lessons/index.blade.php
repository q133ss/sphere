@foreach($lessons as $lesson)
    <div class="s-list__block-items">
        <div class="s-list__block-items-info">
            <div class="s-list__block-items-info-photo" style="background-image: url('{{$lesson->teacher->avatar}}'); background-size:cover;"> </div>
            <div class="s-list__block-items-info-name">{{$lesson->teacher->full_name}}</div>
            <div class="s-list__block-items-info-lesson">{{$lesson->subject->name}}</div>
            <div class="s-list__block-items-info-date">{{$lesson->start->diffForHumans()}}</div>
        </div>
        <div class="s-list__block-items-btn">
            @if($lesson->status == 'future')
                <p>Состоится</p>
            @elseif($lesson->status == 'success')
                <p>Урок завершен</p>
            @elseif($lesson->status == 'canceled')
                <p>Урок отменен</p>
            @elseif($lesson->status == 'progress')
                <p>Урок идет</p>
            @endif
        </div>
    </div>
@endforeach
