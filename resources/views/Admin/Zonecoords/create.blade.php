{!! Form::open(['method' => 'POST', 'route' => 'admin.zonecoords.store', 'class' => 'form-horizontal', 'id'=>'coordenatesForm']) !!}
@include('Admin.Zonecoords.partials.inputs')
<div class="btn-group d-flex mb-3 pt-2">
    <input type="hidden" name="markers" id="markers">
    <button class="btn btn-success m-2" type="sumbit">
        <i class="fas fa-save"></i>Agregar
    </button>
    <button type="button" class="btn btn-danger m-2" data-bs-dismiss="modal"><i class="fas fa-window-close"></i>Regresar</button>
</div>
{!! Form::close() !!}
<script>
    var latInput = document.getElementById('latitude');
    var lonInput = document.getElementById('longitude');
    var map;
    var markers = [];
    function initMap() {
        var lat = parseFloat(latInput.value);
        var lng = parseFloat(lonInput.value);


        if (isNaN(lat) || isNaN(lng)) {
            // Obtener ubicación actual si los campos están vacíos o no contienen valores numéricos válidos
            navigator.geolocation.getCurrentPosition(function(position) {
                lat = position.coords.latitude;
                lng = position.coords.longitude;
                latInput.value = lat;
                lonInput.value = lng;
                displayMap(lat, lng);
            });
        } else {
            // Utilizar las coordenadas de los campos de entrada
            displayMap(lat, lng);
        }
    }

    function addMarker(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map,
                draggable: true
            });
            marker.addListener('rightclick', function() {
                removeMarker(marker);
            });

            markers.push(marker);
        }

    function removeMarker(marker) {
        var index = markers.indexOf(marker);
        if (index !== -1) {
            markers.splice(index, 1);
            marker.setMap(null);
        }
    }

    function displayMap(lat, lng) {
        var mapOptions = {
            center: {
                lat: lat,
                lng: lng,
            },
            zoom: 18
        };

        map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var marker= new google.maps.Marker({
            position:{
                lat: lat,
                lng: lng
            },
            map: map,
            draggable: true
        });
        google.maps.event.addListener(marker, 'dragged', function (event) {
            var latLng = event.latLng;
            latInput.value = latLng.lat();
            lonInput.value = latLng.lng();
        });
        markers.push(marker);

        map.addListener('click', function(event) {
                addMarker(event.latLng);
        });

        var perimeterCoords = @json($vertices);
        var convertedCoords = perimeterCoords.map(function(coord) {
            return {
                lat: parseFloat(coord.lat),
                lng: parseFloat(coord.lng)
            };
        });
        var colors = ['#FF0000', '#ff7433', '#0000FF', '#FFFF00', '#33ddff ', '#00FFFF'];
        var color = colors[Math.random()*4 % colors.length];

        var perimeterPolygon = new google.maps.Polygon({
            paths: convertedCoords,
            strokeColor: color,
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: color,
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
<script>
document.getElementById('coordenatesForm').addEventListener('submit', function(event) {
    var markerData = markers.map(marker => {
        return {
            latitude: marker.getPosition().lat(),
            longitude: marker.getPosition().lng()
        };
    });

    document.getElementById('markers').value = JSON.stringify(markerData);
});
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
</script>
