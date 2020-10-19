<div class="row">
    <div class="col-12">
        <div class="form-group">
            {!! Form::label($attribute->key(), $attribute->param('name')) !!}
            {!! Form::textarea($attribute->key(), old($attribute->key(), $value ?? ''), ['class' => 'form-control', 'rows' => $attribute->param('rows', 10), 'placeholder' => $attribute->param('name')]) !!}
        </div>
    </div>
</div>
