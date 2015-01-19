(function ($) {
    "use strict";
    
    var MapHome = function () {
    	this.data  = $('#map_data');
    	//this.map_id = document.getElementById('dln_map_canvas');
    	
    	this.initMap();
    	this.initClusterMarkers();
    	this.initMarkers();
    	this.map.addLayer(this.markers);
    }
    
    MapHome.prototype.initMap = function () {
    	var self = this;
    	var tiles = L.tileLayer('http://mt1.google.com/vt/lyrs=m@110&hl=pl&x={x}&y={y}&z={z}', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://osm.org/copyright">DinhLN</a> contributors'
        }),
        // default lat lng
        latlng = L.latLng(21.033333, 105.85000000000000);

    	this.map = L.map('dln_map', {center: latlng, zoom: 15, layers: [tiles], scrollWheelZoom: false});
    };
    
    MapHome.prototype.initClusterMarkers = function () {
    	var self = this;
    	
    	this.markers = L.markerClusterGroup({
            maxClusterRadius: 70,
            iconCreateFunction: function (cluster) {
                var markers = cluster.getAllChildMarkers();
                var n = 0;
                for (var i = 0; i < markers.length; i++) {
                    n += markers[i].number;
                }
                return L.divIcon({ html: '<div class="dln-cluster">'+n+'</div>', className: 'dln-cluster-bg', iconSize: L.point(36, 36) });
            },
            //Disable all of the defaults:
            spiderfyOnMaxZoom: true, showCoverageOnHover: false, zoomToBoundsOnClick: true
        });
    };
    
    MapHome.prototype.initMarkers = function () {
    	var self = this;
    	/*var objs = JSON.parse(self.data);
    	
    	$.each(objs, function (key, val) {
    		var id  = key.id;
    		var lat = key.lat;
    		var lng = key.lng;
    		var price = key.price;
    		
    		if (id && lat && lng && price) {
    			self.addMarker(id, lat, lng, price);
    		}
    	});*/
    	for (var i = 0; i < 100; i++) {
    		var divIcon = L.divIcon({className: 'dln-marker', html: '<span class="label label-info">' + i + ',000,000 đ</span>'});
            var m = L.marker(self.getRandomLatLng(self.map), { title: i, icon: divIcon });
            m.number = i;
            self.markers.addLayer(m);
        }
    };
    
    /*MapHome.prototype.addMarker = function (id, lat, lng, price) {
    	var self = this;
    	
    	var latlng = new google.maps.LatLng(this.lat_val, this.long_val);
    	var marker = new DLN_CustomMarker(latlng, self.map);
    	
    	// Add click events
    	google.maps.event.addListener(marker, 'click', function () {
    		console.log('click');
    	});
    	
    	this.markers.push(marker);
    };*/
    
    MapHome.prototype.getRandomLatLng = function (map) {
        var bounds = map.getBounds(),
            southWest = bounds.getSouthWest(),
            northEast = bounds.getNorthEast(),
            lngSpan = northEast.lng - southWest.lng,
            latSpan = northEast.lat - southWest.lat;

        return L.latLng(
                southWest.lat + latSpan * Math.random(),
                southWest.lng + lngSpan * Math.random());
    };
    
    $(document).ready(function () {
    	var obj = new MapHome();
    });
    
}(window.jQuery));