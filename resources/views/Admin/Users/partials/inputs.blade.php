<div class="form-group">
    {!! Form::label('name', 'Nombre') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Ingrese el nombre'
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('lastname', 'Apellido') !!}
    {!! Form::text('lastname', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Ingrese el apellido'
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('DNI', 'DNI') !!}
    {!! Form::text('DNI', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Ingrese el DNI'
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('birthdate', 'Fecha de Nacimiento') !!}
    {!! Form::date('birthdate', null, [
        'class' => 'form-control',
        'required' => 'required'
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('email', 'Correo Electrónico') !!}
    {!! Form::email('email', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Ingrese el correo electrónico'
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('license', 'Licencia de Conducir') !!}
    {!! Form::text('license', null, [
        'class' => 'form-control',
        'placeholder' => 'Ingrese el número de licencia de conducir'
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('address', 'Dirección') !!}
    {!! Form::text('address', null, [
        'class' => 'form-control',
        'placeholder' => 'Ingrese la dirección'
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('password', 'Contraseña') !!}
    {!! Form::password('password', [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Ingrese una contraseña segura'
    ]) !!}
</div>