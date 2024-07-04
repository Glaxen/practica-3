<div class="form-group">
    {!! Form::label('name', 'Nombre',) !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Coloque el nombre del tipo vehiculo',
        ]) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Descripción',) !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Coloque la descripción del tipo de vehiculo',
        'rows' => '4'
        ]) !!}
</div>
