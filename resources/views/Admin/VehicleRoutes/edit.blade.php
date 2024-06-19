{!! Form::model($vehicleroute,['method' => 'PUT', 'route' => ['admin.vehicleroute.update',$vehicleroute], 'class' => 'form-horizontal']) !!}
@include('Admin.Vehicleroutes.partials.inputsSingleEdit')
<div class="btn-group d-flex mb-3 pt-2">
    <button class="btn btn-success m-2" type="sumbit">
        <i class="fas fa-save"></i>Guardar
    </button>
    <button type="button" class="btn btn-danger m-2" data-bs-dismiss="modal"><i class="fas fa-window-close"></i>Regresar</button>
</div>
{!! Form::close() !!}
