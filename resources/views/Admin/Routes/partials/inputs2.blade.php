<div class="form-group">
    {!! Form::label('name', 'Nombre de la rutaAAA') !!}
    {!! Form::text('name', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Ingrese el nombre de la ruta',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('status', 'Estado') !!}
    {!! Form::select('status', ['1' => 'Activa', '0' => 'Inactiva'], null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Seleccione el estado de la ruta',
    ]) !!}
</div>
<div class="form-group">
    <label for="map">Mapa</label>
    <div id="map" style="height: 400px;"></div> <!-- Contenedor para el mapa -->
</div>
<div class="form-group">
    {!! Form::label('latitude_start', 'Latitud de inicio') !!}
    {!! Form::text('latitude_start', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Latitud del punto de inicio',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('longitude_start', 'Longitud de inicio') !!}
    {!! Form::text('longitude_start', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Longitud del punto de inicio',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('latitude_end', 'Latitud de fin') !!}
    {!! Form::text('latitude_end', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Latitud del punto de fin',
    ]) !!}
</div>
<div class="form-group">
    {!! Form::label('longitude_end', 'Longitud de fin') !!}
    {!! Form::text('longitude_end', null, [
        'class' => 'form-control',
        'required' => 'required',
        'placeholder' => 'Longitud del punto de fin',
    ]) !!}
</div>
<!-- Campo oculto para almacenar los IDs de las zonas -->
<!-- El input ahora puede aceptar múltiples valores como un array -->
<div id="intersectedZoneIdsContainer"></div>





<script>
    var map;
    var routeControl;
    var intersectedZones = [];
    var markers = [];
    var startPoint = @json($route->latitude_start ?? null);
    var startLong = @json($route->longitude_start ?? null);
    var endPoint = @json($route->latitude_end ?? null);
    var endLong = @json($route->longitude_end ?? null);

    function initMap() {
        if (!map) {
            map = L.map('map').setView([-6.771913, -79.838516], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            var zonesData = @json($zones ?? []);
            var zonePolygons = zonesData.map(zone => {
                var latlngs = zone.zonecoords.map(coord => [coord.latitude, coord.longitude]);
                var polygon = L.polygon(latlngs, {
                    color: 'blue',
                    zoneId: zone.id
                }).addTo(map);
                polygon.bindPopup("Zona: " + zone.name);
                return polygon;
            });

            // Establecer marcadores iniciales no movibles para la edición
            if (startPoint && startLong) {
                L.marker([startPoint, startLong]).addTo(map);
                $('input[name="latitude_start"]').val(startPoint);
                $('input[name="longitude_start"]').val(startLong);
            }

            if (endPoint && endLong) {
                L.marker([endPoint, endLong]).addTo(map);
                $('input[name="latitude_end"]').val(endPoint);
                $('input[name="longitude_end"]').val(endLong);
            }

            // Agregar nuevos marcadores movibles para nueva ruta
            map.on('click', function(e) {
                if (markers.length >= 2) {
                    markers.forEach(marker => map.removeLayer(marker));
                    markers = [];
                    if (routeControl) {
                        map.removeControl(routeControl);
                        routeControl = null;
                    }
                }

                var marker = L.marker(e.latlng).addTo(map);
                markers.push(marker);

                if (markers.length === 1) {
                    $('input[name="latitude_start"]').val(e.latlng.lat);
                    $('input[name="longitude_start"]').val(e.latlng.lng);
                } else if (markers.length === 2) {
                    $('input[name="latitude_end"]').val(e.latlng.lat);
                    $('input[name="longitude_end"]').val(e.latlng.lng);

                    var routeLine = turf.lineString([
                        [parseFloat($('input[name="longitude_start"]').val()), parseFloat($(
                            'input[name="latitude_start"]').val())],
                        [parseFloat($('input[name="longitude_end"]').val()), parseFloat($(
                            'input[name="latitude_end"]').val())]
                    ]);

                    zonePolygons.forEach(polygon => {
                        if (turf.booleanIntersects(polygon.toGeoJSON(), routeLine)) {
                            console.log("La ruta intersecta con la zona:", polygon.getPopup()
                                .getContent());
                            intersectedZones.push(polygon.options.zoneId);
                        }
                    });

                    routeControl = L.Routing.control({
                        waypoints: [
                            L.latLng(parseFloat($('input[name="latitude_start"]').val()),
                                parseFloat($('input[name="longitude_start"]').val())),
                            L.latLng(parseFloat($('input[name="latitude_end"]').val()), parseFloat(
                                $('input[name="longitude_end"]').val()))
                        ],
                        routeWhileDragging: true,
                        geocoder: L.Control.Geocoder.nominatim()
                    }).addTo(map);

                    $('#intersectedZoneIdsContainer')
                        .empty();
                    intersectedZones.forEach(function(zoneId) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'zone_ids[]',
                            value: zoneId
                        }).appendTo('#intersectedZoneIdsContainer');
                    });

                }
            });
        }
    }

    function drawRoute() {
        if (routeControl) {
            map.removeControl(routeControl);
        }
        routeControl = L.Routing.control({
            waypoints: [
                L.latLng(parseFloat($('input[name="latitude_start"]').val()), parseFloat($(
                    'input[name="longitude_start"]').val())),
                L.latLng(parseFloat($('input[name="latitude_end"]').val()), parseFloat($(
                    'input[name="longitude_end"]').val()))
            ],
            routeWhileDragging: true,
            geocoder: L.Control.Geocoder.nominatim()
        }).addTo(map);
    }
</script>
