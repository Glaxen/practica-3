@extends('adminlte::page')

@section('title', 'User Types')

@section('content_header')
    <h1>Listado de Tipos de Usuario</h1>
@stop

@section('content')

<!-- Modal -->
<div class="modal fade" id="modalusertype" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Nuevo Tipo de Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
        </div>
    </div>
</div>

<div class="p-2">
    <div class="card">
        <div class="card-body">
            <button id="btnCreateUsertype" class="btn btn-success float-right">
                <i class="fas fa-plus mr-1"></i>Nuevo
            </button>
            <table class="datatable table text-center" id="usertypesTable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>NOMBRE</th>
                        <th>DESCRIPCION</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usertypes as $usertype)
                    <tr>
                        <td>{{ $usertype->id }}</td>
                        <td>{{ $usertype->name }}</td>
                        <td>{{ $usertype->description }}</td>
                        <td>
                            <div class="row">
                                <div class="col">
                                    <button id="{{ $usertype->id }}" type="button" class="btnEditUsertype btn btn-primary">
                                        <i class="fas fa-solid fa-pen"></i>
                                    </button>
                                </div>
                                @if ($usertype->id > 5)
                                    <div class="col-6">

                                        <form class="frmDelete" action="{{ route('admin.usertypes.destroy', $usertype->id) }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    $('#usertypesTable').DataTable({
        'language': {
            "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
        }
    });
    $('#btnCreateUsertype').click(function() {
        $.ajax({
            url: "{{ route('admin.usertypes.create') }}",
            type: "GET",
            success: function (response) {
                $('#modalusertype .modal-body').html(response);
                $('#modalusertype').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    $('.btnEditUsertype').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            url: "{{ route('admin.usertypes.edit', '_id') }}".replace('_id', id),
            type: "GET",
            success: function (response) {
                $('#modalusertype .modal-body').html(response);
                $('#modalusertype #modalLabel').html('Actualizar Tipo de Usuario');
                $('#modalusertype').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    $(document).ready(function() {
        $('.frmDelete').on('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: "Estás seguro?",
                text: "Estás seguro que deseas eliminar este tipo de usuario?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonText: "Cancelar",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar"
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        })
    });
</script>
@if (session('success'))
<script>
    Swal.fire({
        title: "Buen trabajo!",
        text: '{{ session('success') }}',
        icon: "success"
    });
</script>
@endif
@if (session('error'))
<script>
    Swal.fire({
        title: '¡Cuidado!',
        text: '{{ session('error') }}',
        icon: 'error',
        confirmButtonText: 'Aceptar'
    });
</script>
@endif
@stop
