@if($value)
    <div class="row">
        <div class="col-12">
            <img src="{{$value}}" class="img-thumbnail" alt="">
        </div>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!! Form::label($attribute->key(), $attribute->param('name')) !!}
            {!! Form::file($attribute->key(), ['class' => 'form-control-file']) !!}
        </div>
    </div>
</div>

