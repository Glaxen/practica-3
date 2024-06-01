{!! Form::open(['method' => 'POST', 'route' => 'admin.vehicleoccupants.store', 'class' => 'form-horizontal',]) !!}
@include('Admin.Vehiclesoccupant.Partials.inputs')
<div class="container">
    <h5>Personal asignado</h5>
    <ul class="list-group" id="listaoccupants">
    </ul>
</div>
<div class="btn-group d-flex mb-3 pt-2">
    <button class="btn btn-success m-2" type="sumbit">
        <i class="fas fa-save"></i>Confirmar asignacion
    </button>
    <button type="button" class="btn btn-danger m-2" data-bs-dismiss="modal"><i class="fas fa-window-close"></i>Regresar</button>
</div>
{!! Form::close() !!}
