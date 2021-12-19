
function initMap() {
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap'
    };

    // Display a map on the web page
    map = new google.maps.Map(document.getElementById("mapCanvas"), mapOptions);
    map.setTilt(50);

    // Multiple markers location, latitude, and longitude
    var markers = [
        // <?php
        // $findcluster = selectAll('input_cluster');
        // foreach ($findcluster as $cluster) {

        //     echo '["' . $cluster['Name_of_cluster_Area'] . '", ' . $cluster['Longitude'] . ', ' . $cluster['Latitude'] . '],';
        // }
        // ?>
    ];
    console.log(markers);

    // Info window content
    var infoWindowContent = [
        // <?php
        // $findcluster = selectAll('input_cluster');
        // foreach ($findcluster as $cluster) {
        // ?>['<div class="info_content">' +
        //         '<h3><?php // echo $cluster['Name_of_cluster_Area']; 
        //                 ?></h3>' +
        //         '<p>Number of farmers in cluster <?php // echo $cluster['Number_of_Farmer_in_the_Cluster']; 
        //                                             ?> and Total number of Hectares <?php //echo $cluster['Size_of_Cluster_Farm_LandHa']; 
        //                                                                             ?> in this Cluster</p>' + '</div>'],
        // <?php
        // // }
        // ?>
    ];

    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(),
        marker, i;

    // Place each marker on the map  
    for (i = 0; i < markers.length; i++) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0]
        });

        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Center the map to fit all markers on the screen
        map.fitBounds(bounds);
    }

    // Set zoom level
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function (event) {
        this.setZoom(14);
        google.maps.event.removeListener(boundsListener);
    });

    // Load initialize function
    google.maps.event.addDomListener(window, 'load', initMap);

}