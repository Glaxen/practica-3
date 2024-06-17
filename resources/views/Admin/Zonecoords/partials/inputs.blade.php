<div class="form-row">
    {!! Form::hidden('zone_id', $zone->id, []) !!}
    <div class="form-group col-6">
        {!! Form::label('latitude','Latitud') !!}
        {!! Form::text('latitude', old('latitude', $lastcoord->lat ?? ''), [
            'class' => 'form-control',
            'placeholder'=>'Latitud',
            'readonly',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('longitude','Longitud') !!}
        {!! Form::text('longitude', old('longitude', $lastcoord->lng ?? ''), [
            'class' => 'form-control',
            'placeholder'=>'Longitud',
            'readonly',
            'required',
        ]) !!}
    </div>
</div>
<div id="map" style="height: 400px; width: 100%;"></div><br>
