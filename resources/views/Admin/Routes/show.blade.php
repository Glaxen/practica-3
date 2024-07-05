{!! Form::model($route, ['method' => 'PUT', 'route' => ['admin.routes.update', $route], 'class' => 'form-horizontal']) !!}
@include('admin.routes.partials.inputs2')
<div class="btn-group d-flex mb-3 pt-2">
    <button class="btn btn-success m-2" type="submit">
        <i class="fas fa-save"></i> Guardar
    </button>
    <button type="button" class="btn btn-danger m-2" data-bs-dismiss="modal">
        <i class="fas fa-window-close"></i> Regresar
    </button>
</div>
{!! Form::close() !!}
    