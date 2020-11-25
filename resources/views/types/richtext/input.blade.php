<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!! Form::label($attribute->key(), $attribute->param('name')) !!}
            {!! Form::textarea($attribute->key(), $value, ['class' => 'form-control editor', 'style' => 'height:500px']) !!}
        </div>
    </div>
</div>
