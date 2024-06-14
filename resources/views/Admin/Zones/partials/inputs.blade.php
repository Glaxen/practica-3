<div class="form-group">
    {!! Form::label('name', 'Nombre',) !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Coloque el nombre de la zona',
        ]) !!}
</div>
<div class="form-group">
    {!! Form::label('area', 'Area',) !!}
    {!! Form::text('area', null, [
        'class' => 'form-control',
        'placeholder' => 'Coloque el area de la zona',
        ]) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Descripción',) !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Coloque la descripción de la marca',
        'rows' => '4'
        ]) !!}
</div>
