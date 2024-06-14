@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Marcas</h1>
@stop

@section('content')
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
  <!-- Modal -->
  <div class="modal fade" id="modalbrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Vehiculo</h1>
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
            <button id="btncreatebrand" class="btn btn-success float-right btncreate">
                <i class="fas fa-plus mr-1"></i>Nuevo
            </button>
            <table class="datatable table text-center" id="brandstrable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>IMAGEN</th>
                        <th>NOMBRE</th>
                        <th>MARCA</th>
                        <th>MODELO</th>
                        <th>TIPO</th>
                        <th>PLACA</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                    <tr>
                        <td>{{$vehicle->id}}</td>
                        <td>
                            <img src="{{ asset($vehicle->image) }}" alt="" width="120px">
                        </td>
                        <td>{{$vehicle->name}}</td>
                        <td>{{$vehicle->brand}}</td>
                        <td>{{$vehicle->model}}</td>
                        <td>{{$vehicle->type}}</td>
                        <td>{{$vehicle->plate}}</td>
                        <td>
                            <div class="row">
                                {{-- botton de editar --}}
                                <div class="col-6">
                                    <button id="{{$vehicle->id}}" type="button" class="btneditbrand btn btn-primary">
                                        <i class="fas fa-solid fa-pen"></i>
                                    </button>
                                </div>
                                {{-- boton de borrar  --}}
                                <div class="col-6">
                                    <form class="frmDelete" action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-solid fa-trash"></i></button>
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
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
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
                url:"{{ route('filterbybrand', '_id') }}".replace('_id',selectbrand.value),
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
    $('#btncreatebrand').click(function() {
        $.ajax({
            url:"{{ route('admin.vehicles.create') }}",
            type: "GET",
            success: function (response) {
                $('#modalbrand .modal-body').html(response);
                listmodelbrand();
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
            url:"{{ route('admin.vehicles.edit','_id') }}".replace('_id',id),
            type: "GET",
            success: function (response) {
                $('#modalbrand .modal-body').html(response);
                listmodelbrand();
                $('#modalbrand #exampleModalLabel').html('Actualizar Vehiculo');
                $('#modalbrand').modal('show');
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
