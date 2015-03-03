(function ($) {
    "use strict";

    var ModalLocation = function () {
        this.$lat     = $('input[name="lat"]');
        this.$long    = $('input[name="lng"]');
        this.$map     = $('#dln_map_canvas');
        this.$address = $('#dln_location');
        this.map_id          = document.getElementById('dln_map_canvas');
        this.autocomplete_id = document.getElementById('dln_location');
        this.zoom_in         = document.getElementById('dln_zoom_in');
        this.zoom_out        = document.getElementById('dln_zoom_out');
        this.lat_val      = (this.$lat.length && this.$lat.val()) ? this.$lat.val() : '21.0277644';
        this.long_val     = (this.$long.length && this.$long.val()) ? this.$long.val() : '105.83415979999995';
        this.geocoder     = null;
        this.marker       = null;
        this.map          = null;
        this.autocomplete = null;
        this.latlng       = new google.maps.LatLng(this.lat_val, this.long_val);
        this.s_placeholder = 'Nhập địa chỉ';
        
        this.initMap();
        this.initMarker();
        this.initAutocomplete();
        this.initEvents();
        
        var self = this;
        $('#dln_track').on('click', function (e) {
        	e.preventDefault();
        	self.geolocate();
        });
    };
    
    ModalLocation.prototype.initMap = function () {
        var self = this;
        
        var options = {
            zoom: 16,
            center: this.latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            disableDoubleClickZoom: false,
            draggableCursor:'crosshair'
        };
        this.map      = new google.maps.Map(self.map_id, options);
        this.geocoder = new google.maps.Geocoder();
    };
    
    ModalLocation.prototype.initMarker = function () {
        var self = this;
        
        this.marker = new google.maps.Marker({
            map: self.map,
            draggable: false,
            position: self.latlng
        });
        this.marker.setVisible(false);
    };
    
    ModalLocation.prototype.initAutocomplete = function () {
        var self = this;
        
        self.autocomplete = new google.maps.places.Autocomplete(self.autocomplete_id, {
            types: ['geocode']
        });
        
        // Prevent enter key
        self.$address.keypress(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });
    };
    
    ModalLocation.prototype.initEvents = function () {
        var self = this;
        
        /*google.maps.event.addListener(self.map, "dblclick", function (e) {
            var current_location = e.latLng;
            self.marker.setPosition(current_location);
            var point = self.marker.getPosition();
            self.map.panTo(point);
            self.loadAddress();
        });*/
        
        google.maps.event.addListener(self.map, 'drag', function () {
            $('.dln-pin-map').addClass('moving');
        });
        
        google.maps.event.addListener(self.map, 'dragend', function (event) {
            $('.dln-pin-map').removeClass('moving');
            self.loadAddress();
        });
        
        /*// For dragend marker
        google.maps.event.addListener(self.marker, 'dragend', function (event) {
           var point = self.marker.getPosition() ;
           self.map.panTo(point);
           self.loadAddress();
        });
        
        //Add listener to marker for reverse geocoding
        google.maps.event.addListener(self.marker, 'drag', function () {
            //self.loadAddress();
        });*/
        
        // For autocomplete
        google.maps.event.addListener(self.autocomplete, 'place_changed', function () {
            // hide marker
            self.marker.setVisible(false);
            
            var place = self.autocomplete.getPlace();
            if (place.geometry) {
                self.map.panTo(place.geometry.location);
                self.map.setZoom(15);
                
                self.marker.setPosition(place.geometry.location);
                self.marker.setVisible(true);
                self.$lat.val(self.marker.getPosition().lat());
                self.$long.val(self.marker.getPosition().lng());
            } else {
                self.$address.placeholder = self.s_placeholder;
            }
        });
        
        google.maps.event.addDomListener(self.zoom_out, 'click', function () {
            var currentZoomLevel = self.map.getZoom();
            if (currentZoomLevel != 0) {
                self.map.setZoom(currentZoomLevel - 1);
                $('#dln_zoom_in').removeClass('disabled');
            } else {
                $('#dln_zoom_out').addClass('disabled');
            }
        });

        google.maps.event.addDomListener(self.zoom_in, 'click', function () {
            var currentZoomLevel = self.map.getZoom();
            if (currentZoomLevel != 21) {
                self.map.setZoom(currentZoomLevel + 1);
                $('#dln_zoom_out').removeClass('disabled');
            } else {
                $('#dln_zoom_in').addClass('disabled');
            }
        });

    };
    
    ModalLocation.prototype.loadAddress = function () {
        var self = this;
        
        this.geocoder.geocode({'latLng': self.marker.getPosition()}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    self.$lat.val(self.marker.getPosition().lat());
                    self.$long.val(self.marker.getPosition().lng());
                    //self.$address.val(results[0].formatted_address);
                }
            }
        });
    };

    ModalLocation.prototype.geolocate = function () {
        var self = this;
        var ua = navigator.userAgent.toLowerCase(),
        isAndroid = ua.indexOf("android") > -1,
        geoTimeout = isAndroid ? '15000' : '1000';
        
        if (self.autocomplete) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    self.marker.setPosition(geolocation);
                    self.loadAddress();
                    var point = self.marker.getPosition();
                    self.map.panTo(point);
                }, function (response) {
                	if (response.message) {
                		alert(response.message);
                	}
                    console.log(response);
                }, {
                    enableHighAccuracy: true, 
                    maximumAge: 3000, 
                    timeout:geoTimeout
                });
            } else {
                alert('Location services must be enabled to use this');
            }
        }
    };

    $(document).ready(function () {
       var map_drag = new ModalLocation();
    });

}(window.jQuery));
