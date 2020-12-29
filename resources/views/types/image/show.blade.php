@if($value)
    <img src="{{$value}}" alt="" class="img-fluid" style="max-width: 300px">
@else
    <p class="text-muted">Изображение не загружено</p>
@endif
