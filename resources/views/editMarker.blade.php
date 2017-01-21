<!DOCTYPE html>
<html>
@extends('layouts.master')
<body>
<div id="map" class="col-md-9"></div>
<script>
    function initMap() {
        var marker_info = '{{$marker->location}}';
        var latLong = new google.maps.LatLng(parseFloat(marker_info.split(',')[0]), parseFloat(marker_info.split(',')[1]));
        var mapOptions = {
            zoom: 14,
            center: latLong
        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);
        var marker = new google.maps.Marker({
            position: latLong ,
            map: map,
            draggable:true,
        });
    }
</script>

</body>
</html>
