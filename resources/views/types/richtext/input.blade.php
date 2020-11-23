<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!! Form::label($attribute->key(), $attribute->param('name')) !!}
            {!! Form::textarea($attribute->key(), $value, ['class' => 'editor', 'rows' => $attribute->param('rows', 10)]) !!}
        </div>
    </div>
</div>
