{!! Form::model($usertype, ['method' => 'PUT', 'route' => ['admin.usertypes.update', $usertype->id], 'class' => 'form-horizontal', 'files' => true]) !!}
@include('Admin.UserType.partials.inputs')  {{-- Asegúrate de que la ruta al partial sea correcta --}}
<div class="btn-group d-flex mb-3 pt-2">
    <button class="btn btn-success m-2" type="submit">
        <i class="fas fa-save"></i> Guardar
    </button>
    <button type="button" class="btn btn-danger m-2" data-bs-dismiss="modal"><i class="fas fa-window-close"></i> Regresar</button>
</div>
{!! Form::close() !!}
