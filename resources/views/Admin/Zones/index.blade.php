@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Listado de Zonas</h1>
@stop

@section('content')

  <!-- Modal -->
  <div class="modal fade" id="modalbrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva zona</h1>
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
            <button id="btncreatezone" class="btn btn-success float-right btncreate">
                <i class="fas fa-plus mr-1"></i>Nuevo
            </button>
            <table class="datatable table text-center" id="brandstrable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>AREA</th>
                        <th>DESCRIPCION</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($zones as $zone)
                    <tr>
                        <td>{{ $zone->id }}</td>
                        <td>{{ $zone->name }}</td>
                        <td>{{ $zone->area }}</td>
                        <td>{{ $zone->description }}</td>
                        <td>
                            <div class="row">
                                <div class="col-4">
                                    <a class="btn btn-secondary" href="{{ route('admin.zones.show',$zone->id ) }}">
                                        <i class="fas fa-map"></i>
                                    </a>
                                </div>
                                {{-- botton de editar --}}
                                <div class="col-4">
                                    <button id="{{$zone->id}}" type="button" class="btneditzone btn btn-primary">
                                        <i class="fas fa-solid fa-pen"></i>
                                    </button>
                                </div>
                                {{-- boton de borrar  --}}
                                <div class="col-4">
                                    <form class="frmDelete" action="{{ route('admin.zones.destroy', $zone->id) }}" method="post">
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
    $('#btncreatezone').click(function() {
        $.ajax({
            url:"{{ route('admin.zones.create') }}",
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

    $('.btneditzone').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            url:"{{ route('admin.zones.edit','_id') }}".replace('_id',id),
            type: "GET",
            success: function (response) {
                $('#modalbrand #exampleModalLabel').html('Modificar zona');
                $('#modalbrand .modal-body').html(response);
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
                    text: "Estas seguro que deseas eliminar la zona?",
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
