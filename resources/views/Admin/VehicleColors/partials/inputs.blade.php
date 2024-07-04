<div class="form-group">
    {!! Form::label('name', 'Nombre',) !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Coloque el nombre del color',
        ]) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Selecciona el color que desees:') !!}
    {!! Form::color('description',$color->description ?? '#FF0000',
    [
        'class' => 'form-control',
        'required' => 'required',
    ]) !!}
</div>
