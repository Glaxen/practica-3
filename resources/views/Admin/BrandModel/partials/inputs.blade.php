<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('name', 'Nombre',) !!}
        {!! Form::text('name', null, [
            'class' => 'form-control',
            'required' => 'required',
            'placeholder' => 'Coloque la modelo',
            ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('code', 'Codigo',) !!}
        {!! Form::text('code', null, [
            'class' => 'form-control',
            'required' => 'required',
            'placeholder' => 'Coloque el codigo',
            ]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('brand_id', 'Marca',) !!}
    {!! Form::select('brand_id',$brands , null, [
        'class' => 'form-control',
        'required',
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
