@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Edit order</h1>
        {!! Form::model($order) !!}
        {!! Form::hidden('lat',null,['id'=>'lat']) !!}
        {!! Form::hidden('lng',null,['id'=>'lng']) !!}
        {!! Form::hidden('destination_lat',null,['id'=>'to_lat']) !!}
        {!! Form::hidden('destination_lng',null,['id'=>'to_lng']) !!}
        <div class="form-group">
            {!! Form::label('client','Client') !!}
            {!! Form::text('client', null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('from','Take from (type address in map below)') !!}
            {!! Form::text('from',null, ['class'=>'form-control']) !!}
        </div>
        <div id="map_from" style="width: 100%;height:400px;display:block;"></div>
        <div class="form-group">
            {!! Form::label('to','Transport to (type address in map below)') !!}
            {!! Form::text('to',null, ['class'=>'form-control']) !!}
        </div>
        <div id="map_to" style="width: 100%;height:400px;display:block;"></div>
        <div class="form-group">
            {!! Form::label('status','Status') !!}
            {!! Form::select('status',config('statuses'),null, ['class'=>'form-control']) !!}
        </div>

        {!! Form::submit('Update',['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_-oa-Eh9jdfIfpnGZJLjZewSgXtbyb9c&signed_in=true&libraries=places&language=lt-LT"></script>
    <script type="text/javascript">
        $(function(){

            function updateLoc(lat, lng)
            {
                $('#lat').val(lat);
                $('#lng').val(lng);
                marker.setPosition( new google.maps.LatLng( lat, lng ) );
                map.panTo( new google.maps.LatLng( lat, lng ) );
            }
            function updateLocA(lat, lng)
            {
                $('#to_lat').val(lat);
                $('#to_lng').val(lng);
                marker2.setPosition( new google.maps.LatLng( lat, lng ) );
                map2.panTo( new google.maps.LatLng( lat, lng ) );
            }

            var marker, map, marker2, map2;
            var geocoder = new google.maps.Geocoder();
            function geocodePosition(element, pos) {
                geocoder.geocode({
                    latLng: pos
                }, function(responses) {
                    if (responses && responses.length > 0) {
                        $(element).val(responses[0].formatted_address);
                    } else {
                        $(element).val('-');
                    }
                });
            }
            function initMap() {
                var myLatLng = {lat: {{$order->lat}}, lng: {{$order->lng}}};
                var myLatLng2 = {lat: {{$order->destination_lat}}, lng: {{$order->destination_lng}}};

                map = new google.maps.Map(document.getElementById('map_from'), {
                    zoom: 7,
                    center: myLatLng
                });

                map2 = new google.maps.Map(document.getElementById('map_to'), {
                    zoom: 7,
                    center: myLatLng2
                });

                marker = new google.maps.Marker({
                    position: myLatLng,
                    map: map,
                    title: 'From',
                    draggable:true
                });
                marker2 = new google.maps.Marker({
                    position: myLatLng2,
                    map: map2,
                    title: 'To',
                    draggable:true
                });
                var contentString = '<div>Drag market to set location</div>';

                var infowindow = new google.maps.InfoWindow({
                    content: contentString
                });
                var infowindow2 = new google.maps.InfoWindow({
                    content: contentString
                });

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open(map,marker);
                });
                google.maps.event.addListener(marker2, 'click', function() {
                    infowindow2.open(map2,marker2);
                });
                infowindow.open(map,marker);
                infowindow2.open(map2,marker2);
                google.maps.event.addListener(marker, 'dragend', function (event) {
                    geocodePosition($('#from'),marker.getPosition());
                    updateLoc(this.getPosition().lat(), this.getPosition().lng());
                });
                google.maps.event.addListener(marker2, 'dragend', function (event) {
                    geocodePosition($('#to'),marker2.getPosition());
                    updateLocA(this.getPosition().lat(), this.getPosition().lng());
                });



                var input = document.getElementById('from');
                var to = document.getElementById('to');

                var searchBox = new google.maps.places.SearchBox(input);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                var searchBox2 = new google.maps.places.SearchBox(to);
                map2.controls[google.maps.ControlPosition.TOP_LEFT].push(to);

                searchBox2.addListener('places_changed', function() {
                    var places = searchBox2.getPlaces();

                    if (places.length == 0) {
                        return;
                    }
                    updateLocA(places[0].geometry.location.lat(),places[0].geometry.location.lng());
                    return true;
                });
                searchBox.addListener('places_changed', function() {
                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }
                    updateLoc(places[0].geometry.location.lat(),places[0].geometry.location.lng());
                    return true;
                });
            }
            initMap();
        });
    </script>
@endsection