<div class="form-row">
    <div class="form-group col-4">
        {!! Form::label('vehicle_id', 'Vehiculo',) !!}
        {!! Form::select('vehicle_id',$vehicles , null, [
            'class' => 'form-control',
            'required',
            'id'=>'vehicleselect',
            ]) !!}
        {!! Form::hidden('capacity', $vehiclesCapacity,[
            'id'=>'capacitiesInput'
        ]) !!}
    </div>
    <div class="form-group col-3">
        {!! Form::label('usertype_id', 'Tipo de usuario',) !!}
        {!! Form::select('usertype_id',$usertypes , null, [
            'class' => 'form-control',
            'required',
            'id'=>'selectbrand',
            ]) !!}
    </div>
    <div class="form-group col-4">
        {!! Form::label('user_id', 'Usuario',) !!}
        {!! Form::select('user_id',$users , null, [
            'class' => 'form-control',
            'required',
            'id'=>'selectmodel',
            ]) !!}
    </div>
    <div class="form-group col-1" style="padding-top: 4%">
        <button class="btn btn-primary" id="btnaddoccupant"><i class="fas fa-plus"></i></button>
    </div>
</div>
