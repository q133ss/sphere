<div>
    @for($i = 0; $i < 5; $i++)
        <i class="fa fa-star @if($rate > $i) text-warning @endif"></i>
    @endfor
</div>