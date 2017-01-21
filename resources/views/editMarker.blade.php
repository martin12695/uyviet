<!DOCTYPE html>
<html>
@extends('layouts.master')
<body>
<div id="map" class="col-md-9"></div>
<script>
    function initMap() {
        var myLatlng = new google.maps.LatLng(-25.363882,131.044922);
        var mapOptions = {
            zoom: 4,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById("map"), mapOptions);

// Place a draggable marker on the map
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            draggable:true,
            title:"Drag me!"
        });


    }
</script>

</body>
</html>
