@extends('layouts.dashboard')

@section('content')
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        @foreach($breadcrumbs as $k => $item)
            @if (count($breadcrumbs) - 1 == $k)
                <li class="breadcrumb-item active">{{ $item['name'] }}</li>
            @else
                <li class="breadcrumb-item"><a href="?cat={{ $item['cat'] }}">{{ $item['name'] }}</a></li>
            @endif
        @endforeach
      </ol>
    </nav>
    <div class="btn-toolbar" role="toolbar">
        @foreach($cats as $cat)
            <a href="?cat={{ $cat->id }}" class="btn btn-primary mb-2 mr-2">{{ $cat->name }}</a>
        @endforeach
    </div>
    @if (count($items))
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12 mb-1">
                <input type="text" style="width: 100%" class="js-search">
            </div>
        </div>
        <div class="row">
            @foreach ($items as $item)
                <div class="col-md-3 mb-2 js-items">
                    <a href="{{ route('teacher.material.show', ['id' => $item->id]) }}" class="card">
                        <div class="card-img-top">
                            <img src="{{ $item->link() }}">
                        </div>
                        <div class="card-heading">{{ $item->name }}</div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    
    @endif
@stop

@push('scripts')
    <script>
    var waitJqInterval = setInterval(function(){
        if (typeof($) == 'function') {
            clearInterval(waitJqInterval);
            var searchTimeout = null,
            filterInput = function() {
                clearTimeout(searchTimeout);
                var val = $.trim($('.js-search').val());
                if (val == '') {
                    $('.js-items').show();
                } else {
                    $('.js-items').each(function(){
                        if ($(this).find('.card-heading').text().toLowerCase().indexOf(val.toLowerCase()) >= 0) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            };
            $('.js-search').on('keyup', function(){
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(filterInput, 500);
            });
            $('.js-search').on('change', filterInput);
        }
    }, 100);
    </script>
@endpush