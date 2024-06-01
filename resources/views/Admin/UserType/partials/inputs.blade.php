<div class="form-group">
    {!! Form::label('name', 'Nombre del Tipo de Usuario') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Ingrese el nombre del tipo de usuario'
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Descripción del Tipo de Usuario') !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Ingrese la descripción del tipo de usuario',
        'rows' => '4'
    ]) !!}
</div>
