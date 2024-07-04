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
        <div class="row" style="height: 250px">
            <div class="col" id='mapaActual'>

            </div>
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
<script>
    var map;
    var markers = [];
    function initMap() {
        displayMap();
    }

    function displayMap() {
        var mapOptions = {
            zoom: 15
        };

        map = new google.maps.Map(document.getElementById('mapaActual'), mapOptions);

        var perimeterCoords = @json($coordcap);
        var convertedCoords = perimeterCoords.map(function(coord) {
            return {
                lat: parseFloat(coord.lat),
                lng: parseFloat(coord.lng)
            };
        });
        var perimeterPolygon = new google.maps.Polygon({
            paths: convertedCoords,
            strokeColor: '#33ddff',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#33ddff',
            fillOpacity: 0.35
        });

        perimeterPolygon.setMap(map);



        var bounds = new google.maps.LatLngBounds();

        // Obtener los límites (bounds) del polígono
        perimeterPolygon.getPath().forEach(function(coord) {
            bounds.extend(coord);
        });

        // Obtener el centro de los límites (bounds)
        var centro = bounds.getCenter();

        // Mover el mapa para centrarse en el centro del perímetro
        map.panTo(centro);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
</script>
@stop
