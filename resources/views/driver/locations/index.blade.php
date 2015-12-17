@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>My locations</h1>
        <div>
            @if(!isset($locations->lat))
                Please update Your locations.
            @else
                Your last locations: <b><span id="lat">{{$locations->lat}}</span>, <span id="lng">{{$locations->lng}}</span></b>
            @endif
            <div>Drag marker or click <button type="button" class="btn btn-success btn-sm" id="here">HERE</button> to update Your locations</div>
            <div id="map" style="width: 100%;height:400px;display:block;"></div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_-oa-Eh9jdfIfpnGZJLjZewSgXtbyb9c&signed_in=true"></script>
    <script type="text/javascript">
        $(function(){
            function updateLoc(lat, lng)
            {
                $.ajax({
                    type      : "POST",
                    beforeSend: function (xhr) {
                        xhr.setRequestHeader ("Authorization", "Basic {{base64_encode(session('email').':'.session('password'))}}");
                    },
                    url       : '{{\App\GK\Utilities\API::driver_locations}}',
                    data      : {
                        'lat':lat,
                        'lng':lng
                    },
                    dataType  : "JSON"
                });
                $('#lat').html(lat);
                $('#lng').html(lng);
                marker.setPosition( new google.maps.LatLng( lat, lng ) );
                map.panTo( new google.maps.LatLng( lat, lng ) );
            }
            function getLocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    alert('Your browser does not support Geolocations');
                }
            }
            function showPosition(position) {
                updateLoc(position.coords.latitude, position.coords.longitude);
            }
            $('#here').click(function(){
                getLocation();
            });

            var marker, map;
            function initMap() {
                var myLatLng = {lat: {{isset($locations->lat) ? $locations->lat : 52}}, lng: {{isset($locations->lng) ? $locations->lng : 23}}};

                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 12,
                    center: myLatLng
                });

                marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: 'Hello World!',
                    draggable:true
                });
                var contentString = '<div>Your last location</div><div>Drag market to set other location</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });
                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map,marker);
                });
                infowindow.open(map,marker);
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    updateLoc(this.getPosition().lat(), this.getPosition().lng());
                });
            }
            initMap();
        });
    </script>
@endsection
