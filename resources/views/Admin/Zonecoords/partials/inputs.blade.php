<div class="form-row">
    {!! Form::hidden('zone_id', null, []) !!}
    <div class="form-group col-6">
        {!! Form::label('latitude','Latitud') !!}
        {!! Form::text('latitude', null, [
            'class' => 'form-control',
            'placeholder'=>'latitud',
            'readonly',
            'required',
        ]) !!}
    </div>
    <div class="form-group col-6">
        {!! Form::label('longitude','Longitud') !!}
        {!! Form::text('longitude', null, [
            'class' => 'form-control',
            'placeholder'=>'Longitud',
            'readonly',
            'required',
        ]) !!}
    </div>
</div>
<div id="map" style="height: 400px; width: 100%;"></div><br>

<script>
    var latInput = document.getElementById('latitude');
    var lonInput = document.getElementById('longitude');

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

    function displayMap(lat, lng) {
        var mapOptions = {
            center: {
                lat: lat,
                lng: lng
            },
            zoom: 18
        };

        var map = new google.maps.Map(document.getElementById('map'), mapOptions);

        var marker= new google.maps.Marker({
            position:{
                lat: lat,
                lng: lng
            },
            map: map,
            title: "Coordenada test",
            draggable: true
        });

        google.maps.event.addListener(marker, 'dragged', function (event) {
            var latLng = event.latLng;
            latInput.value = latLng.lat();
            lonInput.value = latLng.lng();
        });
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async defer>
</script>
