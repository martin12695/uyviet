<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Uy Việt</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/bootstrap-select.css">
    <script src="/js/jquery-3.1.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/bootstrap-select.js"></script>
    <style type="text/css">
        .style1 {background-color:#ffffff;font-weight:bold;border:2px #006699 solid;}
    </style>
</head>
<body>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<nav class="navbar navbar-default" >
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Uy Việt</a>
        </div>
        <ul class="nav navbar-nav">
                <li class="active">
                    <select id="province" class="selectpicker" data-live-search="true" data-live-search-style="begins" title="Chọn tỉnh/thành phố">
                        @foreach($listProvince as $province)
                        <option value="{{$province->id}}">{{$province->name}}</option>
                        @endforeach
                    </select>
                </li>
                <li><a href="#">Page 1</a></li>
                <li><a href="#">Page 2</a></li>
                <li><a href="#">Page 3</a></li>

        </ul>
    </div>
</nav>
<div class="nav-side-menu col-md-3" style="position: relative;">
    <div class="brand">Tìm kiếm</div>
    <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
    <div class="menu-list">
        <ul id="menu-content" class="menu-content collapse out">
            <li>
                <div class="input-group col-md-12">
                    <input type="text" class="form-control input-lg" placeholder="Nhập nội dung tìm kiếm" />
                    <span class="input-group-btn">
                        <button class="btn btn-info btn-lg" type="button">
                            <i class="glyphicon glyphicon-search"></i>
                        </button>
                    </span>
                </div>
            </li>
            <li  data-toggle="collapse" data-target="#products" class="collapsed active">
                <a href="#"><i class="fa fa-gift fa-lg"></i> Danh mục cửa hàng <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="products">
                @foreach($shopType as $type)
                <li class="active"><a href="#">{{$type->type}}</a></li>
                @endforeach
            </ul>


            <li data-toggle="collapse" data-target="#service" class="collapsed">
                <a href="#"><i class="fa fa-industry fa-lg"></i> Cấp độ <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="service">
                @foreach($levels as $level)
                    <li class="active"><a href="#">{{$level->type}}</a></li>
                @endforeach
            </ul>


            <li data-toggle="collapse" data-target="#new" class="collapsed">
                <a href="#"><i class="fa fa-industry fa-lg"></i> Tiềm năng <span class="arrow"></span></a>
            </li>
            <ul class="sub-menu collapse" id="new">
                @foreach($tiemnang as $level)
                    <li class="active"><a href="#">{{$level->type}}</a></li>
                @endforeach
            </ul>

            <li>
                <a href="#">
                    <i class="fa fa-industry fa-lg"></i> Quy mô
                </a>
            </li>
        </ul>
    </div>
</div>

<button type="button" id="button">test</button>

<div id="map" class="col-md-9"></div>
<script>
    function initMap() {

        var markers,markerCluster;
        var marker = [];
        var locations = [
            {lat: -31.563910, lng: 147.154312},
            {lat: -33.718234, lng: 150.363181},
            {lat: -33.727111, lng: 150.371124},
            {lat: -33.848588, lng: 151.209834},
            {lat: -33.851702, lng: 151.216968},
            {lat: -34.671264, lng: 150.863657},
            {lat: -35.304724, lng: 148.662905},
            {lat: -36.817685, lng: 175.699196},
            {lat: -36.828611, lng: 175.790222},
            {lat: -37.750000, lng: 145.116667},
            {lat: -37.759859, lng: 145.128708},
            {lat: -37.765015, lng: 145.133858},
            {lat: -37.770104, lng: 145.143299},
            {lat: -37.773700, lng: 145.145187},
            {lat: -37.774785, lng: 145.137978},
            {lat: -37.819616, lng: 144.968119},
            {lat: -38.330766, lng: 144.695692},
            {lat: -39.927193, lng: 175.053218},
            {lat: -41.330162, lng: 174.865694},
            {lat: -42.734358, lng: 147.439506},
            {lat: -42.734358, lng: 147.501315},
            {lat: -42.735258, lng: 147.438000},
            {lat: -43.999792, lng: 170.463352}
        ];
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 3,
            center: {lat: -28.024, lng: 140.887}
        });

        // Create an array of alphabetical characters used to label the markers
        // Add some markers to the map.
        // Note: The code uses the JavaScript Array.prototype.map() method to
        // create an array of markers based on a given "locations" array.
        // The map() method here has nothing to do with the Google Maps API.
        markers = locations.map(function(location, i) {
            return marker[i] = new google.maps.Marker({
                position: location,
                title: 'Courtyard by Marriott',
                //label: labels[i % labels.length]
            });
        });

        // Add a marker clusterer to manage the markers.
        markerCluster = new MarkerClusterer(map, markers,
                {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
        $("#button").click(function (){
            $.ajax({
                type: "GET",
                url: '/location',
                data: '1',
                success: function(data) {
                    locations = data;
                },
            });
            markerCluster.clearMarkers();
            var markers_temp = [];
            locations.map(function(location, i) {
                marker[i] = new google.maps.Marker({
                    position: location,
                    title: 'Courtyard by Marriott',
                    pixelOffset: new google.maps.Size(100,140),
                });
                markers_temp.push(marker[i]);
            });
            markerCluster.addMarkers(markers_temp);

        });
    }
</script>
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAo3ykqb8xloOHX36rgPXSd1zBQilLqy98&callback=initMap">
</script>
</body>