@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Programacion de rutas y vehiculos</h1>
@stop

@section('content')
      <!-- Modal -->
  <div class="modal fade" id="modalbrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva programacion de rutas</h1>
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
            <button id="btncreatebrand" class="float-right btn btn-success btncreate mx-2">
                <i class="fas fa-plus mr-1"></i>Nueva programación
            </button>
            <button type="button" id="filterButton" class="float-right btn btn-warning mx-2">
                <i class="fas fa-filter"></i>&nbsp;Filtrar
            </button>
            <button id="" type="button" class="float-right btn btn-primary multiple_edit mx-2">
                <i class="fas fa-solid fa-pen"></i>&nbsp;Edicion multiple
            </button>
            <div class="float-right mx-2">
                <input id='idedit' name="idedit" class="form-input" type="number" style="width: 60px">
                <button type="submit" class="btneditbrand2 btn btn-primary">
                        <i class="fas fa-solid fa-pen"></i>
                </button>
            </div>

            <table class="datatable table text-center" id="brandstrable">
                <thead>
                    <tr>
                        <th scope="col" colspan="8">
                            <div class="row">
                                <div class="input-group mb-3 col">
                                    <label class="input-group-text" for="vehicle_id">Vehiculos</label>
                                    {!! Form::select('vehicle_id', $vehiculos, null, [
                                        'class'=>'form-select',
                                        'id'=>'vehicles',
                                    ]) !!}
                                </div>
                                <div class="input-group mb-3 col">
                                    <label class="input-group-text" for="route_id">Rutas</label>
                                    {!! Form::select('route_id', $rutas, null, [
                                        'class'=>'form-select',
                                        'id'=>'routes',
                                    ]) !!}
                                </div>
                                <div class="input-group mb-3 col">
                                    <span class="input-group-text"> Fecha inicio</span>
                                    <input type="date" class="form-control" id="fechainicio" placeholder="">
                                </div>
                                <div class="input-group mb-3 col">
                                    <span class="input-group-text"> Fecha fin</span>
                                    <input type="date" class="form-control" id="fechafin" placeholder="">
                                </div>
                            </div>
                            <div class="row">


                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th scope="col" width="5%">Id</th>
                        <th width="10%">VEHICULO</th>
                        <th width="10%">RUTA</th>
                        <th scope="col" width="10%">FECHA PROGRAMADA</th>
                        <th width="10%">HORA PROGRAMADA</th>
                        <th scope="col" width="20%">STATUS</th>
                        <th scope="col">COMENTARIOS</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicleroutes as $vr)
                    <tr>
                        <td>{{$vr->id}}</td>
                        <td>{{$vr->vehiculo}}</td>
                        <td>{{$vr->route}}</td>
                        <td>{{$vr->fecha}}</td>
                        <td>{{$vr->hora}}</td>
                        <td>{{$vr->status}}</td>
                        <td>{{$vr->description}}</td>
                        <td>
                            <div class="col">
                                <button id="{{$vr->id}}" type="button" class="btneditbrand btn btn-primary">
                                    <i class="fas fa-solid fa-pen"></i>
                                </button>
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
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    @stop

@section('js')
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    $('#brandstrable').DataTable({
        columns: [
            { data: 'id' },
            { data: 'vehiculo' },
            { data: 'route' },
            { data: 'fecha' },
            { data: 'hora' },
            { data: 'status' },
            { data: 'description' },
            {
                data: null,
                render: function (data, type, row) {
                    return `
                        <div class="col">
                            <button id="${data.id}" type="button" class="btneditbrand btn btn-primary">
                                <i class="fas fa-solid fa-pen"></i>
                            </button>
                        </div>`;
                }
            }
        ],
        'language': {
                //si no les funciona usen este archivo de manera local
                // "url":"/storage/Spanish.json",
                "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            }
    });
    $('#btncreatebrand').click(function() {
        $.ajax({
            url:"{{ route('admin.vehicleroute.create') }}",
            type: "GET",
            success: function (response) {
                $('#modalbrand .modal-body').html(response);
                $('#modalbrand').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    $('.btneditbrand').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            url:"{{ route('admin.vehicleroute.edit','_id') }}".replace('_id',id),
            type: "GET",
            success: function (response) {
                $('#modalbrand .modal-body').html(response);
                $('#modalbrand #exampleModalLabel').html('Actualizar ruta programada');
                $('#modalbrand').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    $('.btneditbrand2').click(function() {
        var id = $('#idedit').val();
        $.ajax({
            url:"{{ route('admin.vehicleroute.edit','_id') }}".replace('_id',id),
            type: "GET",
            success: function (response) {
                $('#modalbrand .modal-body').html(response);
                $('#modalbrand #exampleModalLabel').html('Actualizar ruta programada');
                $('#modalbrand').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });
    $('#filterButton').click(function() {
            let vehicle_id = $('#vehicles').val();
            let route_id = $('#routes').val();
            let fechainicio = $('#fechainicio').val();
            let fechafin = $('#fechafin').val();

            $.ajax({
                url: '{{ route('filterTableVehicleRoute') }}',
                method: 'GET',
                data: {
                    _token: '{{ csrf_token() }}',
                    vehicle_id: vehicle_id,
                    route_id: route_id,
                    fechainicio: fechainicio,
                    fechafin: fechafin
                },
                success: function(response) {
                    var table = $('#brandstrable').DataTable();
                    table.clear().rows.add(response.data).draw();
                },
                error: function(error) {
                    console.error('Error al filtrar la tabla:', error);
                }
            });
        });
</script>
<script>
   $(document).ready(function() {
        // $('.frmDelete').on('submit', function(event) {
        //     event.preventDefault();
        //     Swal.fire({
        //             title: "Estas seguro?",
        //             text: "Estas seguro que deseas eliminar la categoria?",
        //             icon: "warning",
        //             showCancelButton: true,
        //             confirmButtonColor: "#3085d6",
        //             cancelButtonText: "Cancelar",
        //             cancelButtonColor: "#d33",
        //             confirmButtonText: "Si hazlo"
        //             }).then((result) => {
        //             if (result.isConfirmed) {
        //                 this.submit();

        //             }
        //     });
        // });
        $('.multiple_edit').on('click', function(event) {
            event.preventDefault();
            Swal.fire({
                    title: "Estas seguro?",
                    text: "Los cambios se aplicaran a los registros mostrados en la tabla",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonText: "Cancelar",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Continuar"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        var table = $('#brandstrable').DataTable();
                        var selectedRows = table.rows({ selected: true }).data();
                        if (selectedRows.length<=0) {
                            Swal.fire({
                                title: '¡Cuidado!',
                                text: 'Tu tabla no tiene registros',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }else{
                            var selectedIds = selectedRows.map(row => row.id);
                            $.ajax({
                            url:"{{ route('showMultiUpdateModal') }}",
                            type: "GET",
                            success: function (response) {
                                $('#modalbrand .modal-body').html(response);
                                $('#modalbrand #exampleModalLabel').html('Actualizar conjunto de rutas');
                                $('#modalbrand .modal-body form').append('<input type="hidden" id="selectedId" name="selectedId">');
                                $('#selectedId').val(selectedIds.join(','));
                                $('#modalbrand').modal('show');
                                },
                            error: function(xhr, status, error) {
                                console.error('Error en la solicitud AJAX:', error);
                                }
                            });
                        }

                }
            });
        });
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
