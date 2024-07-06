<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('name', 'Nombre',) !!}
        {!! Form::text('name', null, [
            'class' => 'form-control',
            'required' => 'required',
            'placeholder' => 'Coloque la actividad',
            ]) !!}
    </div>
    <div class=" mb-3 col">
    {!! Form::label('fecha_inicio', 'Fecha de inicio del mantenimiento', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::date('fecha_inicio', null, [
        'class'=>'form-control',
        'id'=>'mantenimiento',
        'required',
    ]) !!}
</div>
<div class=" mb-3 col">
    {!! Form::label('fecha_inicio', 'Fecha de fin del mantenimiento', [
        'class'=>'form-label',
    ]) !!}
    {!! Form::date('fecha_fin', null, [
        'class'=>'form-control',
        'id'=>'mantenimiento',
        'required',
    ]) !!}
</div>

