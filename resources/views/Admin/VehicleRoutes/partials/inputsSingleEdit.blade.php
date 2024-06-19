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
    {!! Form::label('date_route', 'Fecha de inicio de la programación', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::date('date_route', null, [
        'class'=>'form-control',
        'id'=>'routes',
        'required',
    ]) !!}
</div>
<div class=" mb-3 col">
    {!! Form::label('routestatus_id', 'Status de la ruta', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::select('routestatus_id', $statusroute, null, [
        'class'=>'form-select',
        'id'=>'routes',
        'required',
    ]) !!}
</div>
<div class=" mb-3 col">
    {!! Form::label('hour_route', 'Hora que se iniciará el recorrido', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::time('hour_route' ,null, [
        'class'=>'form-control',
        'id'=>'routes',
        'required',
    ]) !!}
</div>



