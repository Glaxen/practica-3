<div class=" mb-3 col">
    {!! Form::label('vehicle_id', 'Vehiculos disponibles', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::select('vehicle_id', $vehiculos, null, [
        'class'=>'form-select',
        'id'=>'vehicles',
        'required',
    ]) !!}
</div>
<div class=" mb-3 col">
    {!! Form::label('route_id', 'Rutas activas', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::select('route_id', $rutas, null, [
        'class'=>'form-select',
        'id'=>'routes',
        'required',
    ]) !!}
</div>
<div class=" mb-3 col">
    {!! Form::label('fecha_inicio', 'Fecha de inicio de la programación', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::date('fecha_inicio', null, [
        'class'=>'form-control',
        'id'=>'routes',
        'required',
    ]) !!}
</div>
<div class=" mb-3 col">
    {!! Form::label('fecha_fin', 'Fecha final de la programación', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::date('fecha_fin', null, [
        'class'=>'form-control',
        'id'=>'routes',
        'required',
    ]) !!}
</div>
<div class=" mb-3 col">
    {!! Form::label('hour_route', 'Hora que se iniciará el recorrido', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::time('hour_route', null, [
        'class'=>'form-control',
        'id'=>'routes',
        'required',
    ]) !!}
</div>



