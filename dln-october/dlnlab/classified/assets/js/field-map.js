(function ($) {
    "use strict";

    var getCurrentLatLng = function () {
        if (navigator.geolocation) {
            $('#dln_find_current').html('<div class="indicator show"><span class="spinner spinner4"></span></div>');
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            console.log("Geolocation is not supported by this browser.");
        }
    }
    var showPosition = function (position) {
        if (position) {
            var myLatlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            var geocoder = new google.maps.Geocoder();
            var request = {};
            request['latLng'] = myLatlng;
            geocoder.geocode(request, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#dln_find_current').html('<i class="ico-location"></i>');
                    var result = results[0];
                    $('#dln_geocomplete').val(result.formatted_address);
                    $("#dln_geocomplete").trigger("geocode");
                }
            });
        }
    };

    $(document).ready(function () {
        var dln_geo = $("#dln_address").geocomplete({
            map: ".dln_map_canvas",
            details: "form ",
            markerOptions: {
                draggable: true
            },
            mapOptions: {
                zoom: 5
            },
            maxZoom: 20,
        });

        $("#dln_address").bind("geocode:dragged", function (event, latLng) {
            var geocoder = new google.maps.Geocoder();
            var request = {};
            request['latLng'] = latLng;
            geocoder.geocode(request, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var result = results[0];
                    $('#dln_address').val(result.formatted_address);
                }
            });
            if (latLng) {
                $('input[name="latitude"]').val(latLng.lat());
                $('input[name="longitude"]').val(latLng.lng());
            }
        });
        $('#dln_address').bind('geocode:result', function (event, result) {
            var latLng = result.geometry.location;
            if (latLng) {
                $('input[name="latitude"]').val(latLng.lat());
                $('input[name="longitude"]').val(latLng.lng());
            }
        });

        $('#dln_find_current').on('click', function (e) {
            e.preventDefault();
            getCurrentLatLng();
        });

        $("#dln_find_address").click(function () {
            $("#dln_address").trigger("geocode");
        }).click();
    });
}(jQuery));