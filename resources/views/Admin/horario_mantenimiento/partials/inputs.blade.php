<div class="form-row">
    <div class="form-group">
        {!! Form::label('dia', 'Día de la actividad') !!}
        {!! Form::select(
            'dia',
            [
                'Lunes' => 'Lunes',
                'Martes' => 'Martes',
                'Miércoles' => 'Miércoles',
                'Jueves' => 'Jueves',
                'Viernes' => 'Viernes',
                'Sábado' => 'Sábado',
            ],
            null,
            [
                'class' => 'form-control',
                'placeholder' => 'Seleccione un día de la semana',
                'required' => 'required',
            ],
        ) !!}
    </div>

    <div class=" mb-3 col">
        {!! Form::label('id_vehiculo', 'Vehículos', [
            'class' => 'form-label',
        ]) !!}
        {!! Form::select('id_vehiculo', $vehiculos, null, [
            'class' => 'form-select',
            'id' => 'vehicles',
            'required',
        ]) !!}
    </div>

    <div class="form-group col-6">
        {!! Form::label('tipo', 'Tipo de mantenimiento') !!}
        {!! Form::text('tipo', null, [
            'class' => 'form-control',
            'required' => 'required',
            'placeholder' => 'Coloque el tipo',
        ]) !!}
    </div>

    <div class="mb-3 col">
        {!! Form::label('hora_inicio', 'Hora Inicio', ['class' => 'form-label']) !!}
        {!! Form::input('time', 'hora_inicio', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class="mb-3 col">
        {!! Form::label('hora_fin', 'Hora Fin', ['class' => 'form-label']) !!}
        {!! Form::input('time', 'hora_fin', null, ['class' => 'form-control', 'required' => 'required']) !!}
    </div>

    <div class=" mb-3 col">
        {!! Form::label('id_mantenimiento', 'Mantenimiento', [
            'class' => 'form-label',
        ]) !!}
        {!! Form::select('id_mantenimiento', $mantenimientos, null, [
            'class' => 'form-select',
            'id' => 'mantenimientos',
            'required',
        ]) !!}
    </div>
