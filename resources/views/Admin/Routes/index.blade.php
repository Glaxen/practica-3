@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Rutas</h1>
@stop

@section('content')

    <!-- Modal -->
    <div class="modal fade" id="modalroute" tabindex="-1" aria-labelledby="modalLabelRoute" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabelRoute">Nueva Ruta</h1>
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
                <button id="btncreateroute" class="btn btn-success float-right btncreate">
                    <i class="fas fa-plus mr-1"></i>Nuevo
                </button>
                <table class="datatable table text-center" id="routestable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOMBRE</th>
                            <th>INICIO LATITUD</th>
                            <th>INICIO LONGITUD</th>
                            <th>FIN LATITUD</th>
                            <th>FIN LONGITUD</th>
                            <th>ESTATUS</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routes as $route)
                            <tr>
                                <td>{{ $route->id }}</td>
                                <td>{{ $route->name }}</td>
                                <td>{{ $route->latitude_start }}</td>
                                <td>{{ $route->longitude_start }}</td>
                                <td>{{ $route->latitude_end }}</td>
                                <td>{{ $route->longitude_end }}</td>
                                <td>{{ $route->status }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-4">
                                            <button id="{{ $route->id }}" type="button"
                                                class="btneditroute btn btn-primary">
                                                <i class="fas fa-solid fa-pen"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button id="{{ $route->id }}" type="button"
                                                class="btnshowroute btn btn-secondary">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <form class="frmDelete" action="{{ route('admin.routes.destroy', $route->id) }}"
                                                method="post">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="fas fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
@stop

@section('js')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@turf/turf"></script>

    <script>
        $('#modalroute').on('shown.bs.modal', function() {
            // Eliminar el mapa existente si ya está inicializado
            if (map) {
                map.remove();
                map = null;
            }
            initMap(); // Inicializa el mapa de nuevo // Inicializa el mapa cuando el modal es visible
        });

        $('#routestable').DataTable({
            'language': {
                "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            }
        });
        $('#btncreateroute').click(function() {
            $.ajax({
                url: "{{ route('admin.routes.create') }}",
                type: "GET",
                success: function(response) {
                    $('#modalroute .modal-body').html(response);
                    $('#modalroute').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        });

        $('.btneditroute').click(function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('admin.routes.edit', '_id') }}".replace('_id', id),
                type: "GET",
                success: function(response) {
                    console.log(response)
                    $('#modalroute #modalLabelRoute').html('Modificar Ruta');
                    $('#modalroute .modal-body').html(response);
                    $('#modalroute').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        });
        $('.btnshowroute').click(function() {
            var id = $(this).attr('id');
            $.ajax({
                url: "{{ route('admin.routes.show', '_id') }}".replace('_id', id),
                type: "GET",
                success: function(response) {
                    console.log(response)
                    $('#modalroute #modalLabelRoute').html('Ver Ruta Actual');
                    $('#modalroute .modal-body').html(response);
                    $('#modalroute').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error('Error en la solicitud AJAX:', error);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.frmDelete').on('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Estas seguro?",
                    text: "Estas seguro que deseas eliminar la ruta?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonText: "Cancelar",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si hazlo"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            })
        })
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
