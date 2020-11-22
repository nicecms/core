<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!! Form::label($attribute->key(), $attribute->param('name')) !!}
            {!! Form::select($attribute->key(), $attribute->param('variants'), $value, ['class' => 'form-control', 'placeholder' => $attribute->param('name')]) !!}
        </div>
    </div>
</div>
