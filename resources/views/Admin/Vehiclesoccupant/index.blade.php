@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Vehiculos asignados a trabajadores</h1>
@stop

@section('content')

  <!-- Modal -->
  <div class="modal fade" id="modalbrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva asignacción</h1>
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
            <table class="datatable table text-center" id="brandstrable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>VEHICULO</th>
                        <th>CAPACIDAD</th>
                        <th>PLACA</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($voc as $vo)
                    <tr>
                        <td>{{$vo->id}}</td>
                        <td>
                            {{$vo->name}}
                        </td>
                        <td>
                            {{$vo->capacity}}
                        </td>
                        <td>
                            {{ $vo->plate }}
                        </td>
                        <td>
                            <div class="row">
                                <div class="col-6">
                                    <button id="btncreatebrand" class="btn btn-success float-right btncreate">
                                        <i class="fas fa-plus mr-1"></i>Nuevo
                                    </button>
                                </div>
                                {{-- botton de editar --}}
                                <div class="col-6">
                                    <button id="{{$vo->id}}" type="button" class="btneditbrand btn btn-primary">
                                        <i class="fas fa-solid fa-pen"></i>
                                    </button>
                                </div>
                                {{-- boton de borrar  --}}
                                {{-- <div class="col-6">
                                    <form class="frmDelete" action="{{ route('admin.vehicleoccupants.destroy', $vo->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-solid fa-trash"></i></button>
                                    </form>
                                </div> --}}
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
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <!-- Bootstrap CSS -->
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
        'language': {
                //si no les funciona usen este archivo de manera local
                // "url":"/storage/Spanish.json",
                "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
            }
    });
    function listmodelbrand() {
        var selectbrand = document.getElementById('selectbrand');
        selectbrand.addEventListener("change",function () {
            $.ajax({
                url:"{{ route('filterbyUsertype', '_id') }}".replace('_id',selectbrand.value),
                type:"GET",
                success: function (response) {
                    $('#selectmodel').empty();
                    $.each(response, function(index, object) {
                        $('#selectmodel').append($('<option>').text(object.name).attr('value', object.id));
                    });
                }
            })
        });
    };

    function initializeOccupantAddition() {
        $('#btnaddoccupant').click(function(event) {
            event.preventDefault();

            var numOccupants = $('#listaoccupants').children().length;
            var capacities = JSON.parse($('#capacitiesInput').val());

            var userName = $('#selectmodel option:selected').text();
            var userType = $('#selectbrand option:selected').text();
            var vehicle = $('#vehicleselect option:selected').text();
            var userId = $('#selectmodel').val();
            var userTypeId = $('#selectbrand').val();
            var vehicleId = $('#vehicleselect').val()

            var maxOccupants = capacities[vehicleId];
            if (numOccupants >= maxOccupants) {
                alert('Se ha alcanzado el límite máximo de ocupantes.');
                return;
            }

            if (userName && userType) {
                var newOccupant = `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            ${userName}
                            <span class="badge badge-primary badge-pill">${userType}</span>
                            <a href=""><span class="badge badge-danger badge-pill"><i class="fas fa-minus"></i></span></a>
                            <input type="hidden" name="occupants[]" value="${vehicleId}_${userTypeId}_${userId}">
                        </li>
                `;

                $('#listaoccupants').append(newOccupant);
            } else {
                alert('Por favor, seleccione un usuario y un tipo de usuario.');
            }
        });
    }
    function validarcapacidad(){
        $('#vehicleselect').change(function() {
        // Obtén el valor seleccionado del combo (ID del vehículo)
        var vehicleId = $(this).val();
        console.log(vehicleId);

        // Obtén la capacidad del vehículo seleccionado
        var capacity = $(this).find(':selected').data('capacity');
        console.log(capacity)
        // Validar la capacidad (ejemplo: capacidad mínima requerida)
        var capacidadMinimaRequerida = 5; // Establece la capacidad mínima requerida
        if (capacity < capacidadMinimaRequerida) {
            // Si la capacidad es menor que la mínima requerida, muestra un mensaje de error
            alert('La capacidad del vehículo seleccionado es insuficiente.');
        } else {
            // La capacidad es válida, puedes continuar con lo que necesites hacer
            console.log('Capacidad válida:', capacity);
        }
        });
    }

    function eliminardelista(){
        $('#listaoccupants').on('click', 'li a', function(event) {
        event.preventDefault(); // Evitar el comportamiento por defecto del enlace

        // Obtener el elemento li padre del enlace y eliminarlo
        $(this).closest('li').remove();
    });
    }

    $('#btncreatebrand').click(function() {
        $.ajax({
            url:"{{ route('admin.vehicleoccupants.create') }}",
            type: "GET",
            success: function (response) {
                $('#modalbrand .modal-body').html(response);
                $('#modalbrand').modal('show');
                listmodelbrand();
                initializeOccupantAddition();
                validarcapacidad();
                eliminardelista();
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
        });
    });

    $('.btneditbrand').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            url:"{{ route('admin.vehicleoccupants.edit','_id') }}".replace('_id',id),
            type: "GET",
            success: function (response) {
                $('#modalbrand .modal-body').html(response);
                $('#modalbrand #exampleModalLabel').html('Actualizar asignacion');
                $('#modalbrand').modal('show');
                listmodelbrand();
                initializeOccupantAddition();
                validarcapacidad();
                eliminardelista();
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
                    text: "Estas seguro que deseas eliminar la categoria?",
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

