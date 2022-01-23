@extends('layouts.dashboard')

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        @foreach($breadcrumbs as $k => $item)
            @if (count($breadcrumbs) - 1 == $k)
                <li class="breadcrumb-item active">{{ $item['name'] }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ route('teacher.material.index', ['cat'=>$item['cat']]) }}">{{ $item['name'] }}</a></li>
            @endif
        @endforeach
      </ol>
    </nav>
    <h1>{{ $material->name }}</h1>
    <p>Всего страниц: {{ $material->page_count }}</p>
    <p>Могу купить: <span class="js-buy-count">{{ $material->canBuyCount() }}</span></p>
    <div class="book">
        @for($i = $material->page_first; $i < $material->page_count; $i++)
            <div class="{{($i > 5 ? 'hide' : 'show').' '.($material->isBuy($i) ? 'buyed' : 'buy')}}">
                <p>{{ $i }}</p>
                <img src="{{ $material->link($i) }}" data-src="{{ $material->link($i, 2) }}">
            </div>
        @endfor
    </div>
    <div class="pages">Показать еще</div>
    <div class="big" style="display:none"></div>
@stop

@push('styles')
    <style>
        .book { display: flex; justify-content: left; flex-wrap: wrap; }
        .book div {  }
        .book div.hide { display: none; }
        .book div.show {  }
        .book div.buyed { background: green; }
        .book div.buy { cursor: pointer; }
        .book p {  }
        .book img {  }
    </style>
@endpush

@push('scripts')
    <script>
    var waitJqInterval = setInterval(function(){
        if (typeof($) == 'function') {
            clearInterval(waitJqInterval);
            $('.book div').on('click', function(e){
                e.preventDefault();
                var count = Number($('.js-buy-count').text())-1;
                if (count < 0) count = 0;
                $('.big').html('<img src="'+$(this).find('img').data('src')+'">').show();
                $('.js-buy-count').text(count);
                $(this).removeClass('buy').addClass('buyed');
            });
            $('.pages').on('click', function(e){
                e.preventDefault();
                $('.book .hide').each(function(i){
                    $(this).removeClass('hide');
                    if (i >= 4) return false;
                });
                if (!$('.book .hide').length) {
                    $('.pages').hide();
                }
            });
        }
    }, 100);
    </script>
@endpush