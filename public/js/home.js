/**
 * Created by Martin on 16/01/2017.
 */

var edit_link = "12";
var tempIW = null;
function getContent(data) {
    return '<div class="info-box-wrap row">     <div class="col-sm-4">      <img src="assets/images/shop.jpg" />        <a class="btn btn-info" id="view-more" data="' + data.shop_id + '">        More</a>    </div>    <div class="info-box-text-wrap col-sm-8">           <h6 class="address">           ' + data.shop_name + '</h6>         <div class="action-btns">           <i class="fa fa-volume-control-phone">           </i>  <strong>  ' + data.namer + ": " + data.phone + '</strong>  <br>           <i class="fa fa-user">           </i>                    <strong>                    ' + data.fullname + '</strong>                    <br>           <i class="fa fa-map-marker">           </i>              <strong>              ' + data.full_address + '</strong>              <br>        </div>        ' + (edit_link != "" ? '<div class="row">   <a target="_blank" class="pull-right" id="edit-shop" data="' + data.shop_id + '"><i class="fa fa-pencil-square-o"></i></a></div>' : '') + '</div>    </div>';
}

function initMap() {
    var markers,markerCluster, marker;
    var markers_temp = [];
    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 6,
        center: {lat: 16.625665, lng: 106.981011}
    });

    markerCluster = new MarkerClusterer(map, markers,
        {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});

    $("#button").click(function (){
        markerCluster.clearMarkers();
        markers = [];
        $.ajax({
            type: "GET",
            url: '/location',
            success: function(data) {
                markers_temp = data;
                for (var i = 0; i < markers_temp.length; i++) {
                    // init markers
                    marker = new google.maps.Marker({
                        position: new google.maps.LatLng(parseFloat(markers_temp[i].location.split(',')[0]), parseFloat(markers_temp[i].location.split(',')[1])),
                        map: map,
                        title: markers_temp[i].shop_name,
                        data : markers_temp[i],
                        icon: {
                            url: markers_temp[i].icon_url,
                            size: new google.maps.Size(50, 50),
                        },

                    });
                    markers.push(marker);
                    (function(marker, i) {
                        google.maps.event.addListener(marker, 'click', function() {
                            infowindow = new google.maps.InfoWindow({
                                content: getContent(marker.data)
                            });
                            if(tempIW)
                                tempIW.close();
                            infowindow.open(map, marker);
                            tempIW = infowindow;
                            google.maps.event.addListener(infowindow, 'domready', function() {
                                $("#view-more").on("click", function() {
                                    view_more($(this).attr("data"));
                                });
                                $("a[id='edit-shop']").on("click", function(){
                                    var shop_id = $(this).attr("data");
                                    open_modal(shop_id);
                                });
                            });
                        });

                    })(marker, i);

                }
                markerCluster.addMarkers(markers);
            },
        });
    });
}