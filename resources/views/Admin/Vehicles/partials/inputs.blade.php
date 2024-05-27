
<div class="form-row">
    <div class="form-group col-8">
        {!! Form::label('name', 'Nombre',) !!}
        {!! Form::text('name', null, [
            'class' => 'form-control',
            'required' => 'required',
            'placeholder' => 'Nombre del Vehiculo',
            ]) !!}
    </div>
    <div class="form-group col-4">
        {!! Form::label('code', 'Codigo',) !!}
        {!! Form::text('code', null, [
            'class' => 'form-control',
            'required' => 'required',
            'placeholder' => 'Codigo del Vehiculo',
            ]) !!}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-6">
        {!! Form::label('brand_id', 'Marca',) !!}
        {!! Form::select('brand_id',$brand , null, [
            'class' => 'form-control',
            'required',
            'id'=>'selectbrand',
            ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('model_id', 'Modelo',) !!}
        {!! Form::select('model_id',$model , null, [
            'class' => 'form-control',
            'required',
            'id'=>'selectmodel',
            ]) !!}
    </div>
</div>
<div class="form-row">
    <div class="form-group col-3">
        {!! Form::label('plate', 'Placa',) !!}
        {!! Form::text('plate', null, [
            'class' => 'form-control',
            'required' => 'required',
            'placeholder' => 'Nombre del Vehiculo',
            ]) !!}
    </div>
    <div class="form-group col-3">
        {!! Form::label('year', 'Año',) !!}
        {!! Form::text('year', null, [
            'class' => 'form-control',
            'placeholder' => 'Nombre del Vehiculo',
            ]) !!}
    </div>
    <div class="form-group col-3">
        {!! Form::label('type_id', 'Tipo',) !!}
        {!! Form::select('type_id',$vtype , null, [
            'class' => 'form-control',
            'required',
            ]) !!}
    </div>
    <div class="form-group col-3">
        {!! Form::label('color_id', 'Color',) !!}
        {!! Form::select('color_id',$vcolor , null, [
            'class' => 'form-control',
            'required',
            ]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('description', 'Descripción',) !!}
    {!! Form::textarea('description', null, [
        'class' => 'form-control',
        'placeholder' => 'Coloque la descripción de la marca',
        'rows' => '4'
        ]) !!}
</div>
<p><b>Estado del vehiculo</b></p>
<div class="form-check">
    {!! Form::checkbox('status', 1, 1, [
        'class' => 'btn-check',
        'autocomplete'=>'off',
        'id' => 'status',
        ]) !!}
    {!! Form::label('status','Activo',[
        'class'=>"btn btn-outline-primary",
    ]) !!}<br>
</div>
<div class="form-row">
    <div class="form-group col-12">
        {!! Form::label('logo', 'Imagen del vehiculo',) !!}
        <br><input type="file" name="logo" class="form-control" accept="image/*">
    </div>
</div>

