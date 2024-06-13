<div class="form-group">
    {!! Form::label('name', 'Nombre',) !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Coloque el nombre de la marca',
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
<div class="form-group">
    {!! Form::label('logo', 'Logo de la marca',) !!}
    <br><input type="file" name="logo" class="form-control" accept="image/*">
</div>
