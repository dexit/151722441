(function ($) {
    "use strict";

    var field_address = "dln_address";
    var longval = "#clf_lat";
    var latval = "#clf_long";
    var mapId = 'dln_map_canvas';
    var geocoder;
    var map;
    var marker;
    var autocomplete;

    function initialize() {
        //MAP
        var initialLat = $(latval).val();
        var initialLong = $(longval).val();
        if (initialLat == '') {
            initialLat = "51.773071843208115";
            initialLong = "-1.6568558468750325";
        }
        var latlng = new google.maps.LatLng(initialLat, initialLong);
        var options = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        map = new google.maps.Map(document.getElementById(mapId), options);

        geocoder = new google.maps.Geocoder();

        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: latlng
        });

        google.maps.event.addListener(marker, "dragend", function (event) {
            var point = marker.getPosition();
            map.panTo(point);
            loadAddressMarker();
        });

    }
    ;

    function loadAddressMarker() {
        geocoder.geocode({'latLng': marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $(latval).val(marker.getPosition().lat());
                    $(longval).val(marker.getPosition().lng());
                    $('#dln_address').val(results[0].formatted_address);
                }
            }
        });
    }

    function geolocate() {
        if (autocomplete) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    autocomplete.setBounds(new google.maps.LatLngBounds(geolocation, geolocation));
                });
            }
        }
    }

    $(document).ready(function () {

        initialize();

        $(function () {
            autocomplete = new google.maps.places.Autocomplete(document.getElementById(field_address), {types: ['geocode']});

            google.maps.event.addListener(autocomplete, 'place_changed', onPlaceChanged);

            function onPlaceChanged() {
                marker.setVisible(false);
                var place = autocomplete.getPlace();
                if (place.geometry) {
                    map.panTo(place.geometry.location);
                    map.setZoom(15);
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);
                } else {
                    document.getElementById(field_address).placeholder = 'Enter a city';
                }

            }

            /*$(PostCodeid).autocomplete({
             //This bit uses the geocoder to fetch address values
             source: function (request, response) {
             geocoder.geocode({ 'address': request.term }, function (results, status) {
             response($.map(results, function (item) {
             return {
             label: item.formatted_address,
             value: item.formatted_address
             };
             }));
             });
             }
             });*/
        });

        // Prevent enter key
        $('#dln_address').keypress(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });

        /*$('#findbutton').click(function (e) {
         var address = $('#' + field_address).val();
         geocoder.geocode({ 'address': address }, function (results, status) {
         if (status == google.maps.GeocoderStatus.OK) {
         map.setCenter(results[0].geometry.location);
         marker.setPosition(results[0].geometry.location);
         $(latval).val(marker.getPosition().lat());
         $(longval).val(marker.getPosition().lng());
         } else {
         alert("Geocode was not successful for the following reason: " + status);
         }
         });
         e.preventDefault();
         });*/

        //Add listener to marker for reverse geocoding
        google.maps.event.addListener(marker, 'drag', function () {
            loadAddressMarker();
        });

    });

}(jQuery));