{!! Form::model($vehicles,['method' => 'PUT', 'route' => ['admin.vehicleoccupants.update',$vehicles], 'class' => 'form-horizontal']) !!}
@include('Admin.Vehiclesoccupant.Partials.inputsedit')
<div>

</div>
<div class="container">
    <h5>Personal asignado</h5>
    <ul class="list-group" id="listaoccupants">
        @foreach($vo as $occupant)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $occupant->user }}
            <span class="badge badge-primary badge-pill">{{ $occupant->tipo }}</span>
            <a href=""><span class="badge badge-danger badge-pill"><i class="fas fa-minus"></i></span></a>
            <input type="hidden" name="ids[]" value="{{ $occupant->id }}">
            <input type="hidden" name="occupants[]" value="{{ $occupant->vehicle_id }}_{{ $occupant->usertype_id }}_{{ $occupant->user_id }}">
        </li>
        @endforeach
    </ul>

</div>
<div class="btn-group d-flex mb-3 pt-2">
    <button class="btn btn-success m-2" type="sumbit">
        <i class="fas fa-save"></i>Confirmar asignacion
    </button>
    <button type="button" class="btn btn-danger m-2" data-bs-dismiss="modal"><i class="fas fa-window-close"></i>Regresar</button>
</div>
{!! Form::close() !!}
