@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
@stop

@section('content')
<div class="modal fade" id="modalCoordenates" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
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


<div class="container card mt-4">
    <div class="card-header">
        <h4 class="float-left">Esta editando la Zona {{ $zone->id }}</h4>
        <button class="btnCreateCoordenates btn btn-success float-right" id="{{ $zone->id }}">Agregar coordenada</button>
        <button class="btnEditCoordenates btn btn-primary float-right mx-2" id="{{ $zone->id }}">Modficar perimetro</button>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-4">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Nombre:</strong> {{ $zone->name }}</li>
                    <li class="list-group-item"><strong>Area:</strong> {{ $zone->area }}</li>
                    <li class="list-group-item"><strong>Descripcion:</strong> {{ $zone->description }}</li>
                </ul><br>
                <a class="btn btn-danger" href="{{ route("admin.zones.index") }}">Volver</a>
            </div>
            <div class="col-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Latitud</th>
                            <th scope="col">Longitud</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($coords as $cordenada)
                        <tr>
                            <td>{{ $cordenada->id }}</td>
                            <td>{{ $cordenada->latitude }}</td>
                            <td>{{ $cordenada->longitude }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col"></div>
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
    $('.btnCreateCoordenates').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            url:"{{ route('admin.zonecoords.edit' ,'_id') }}".replace('_id',id),
            type: "GET",
            success: function (response) {
                $('#modalCoordenates .modal-body').html(response);
                $('#modalCoordenates').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
            });
    });
    $('.btnEditCoordenates').click(function() {
        var id = $(this).attr('id');
        $.ajax({
            url:"{{ route('admin.zonecoords.show' ,'_id') }}".replace('_id',id),
            type: "GET",
            success: function (response) {
                $('#modalCoordenates #exampleModalLabel').html('Modificar perimetro de zona');
                $('#modalCoordenates .modal-body').html(response);

                $('#modalCoordenates').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud AJAX:', error);
            }
            });
    });
</script>
@stop
