/**
 * Created by DinhLN on 5/25/2014.
 */
(function(window){
    var DLN = DLN || {};
    DLN_MapUser = Class.extend({
        options: {
            mapId: 'dln_map',
            tileUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
        },

        init: function(options){
            var _this = this;
            options = L.Util.setOptions(this, options);

            _this._map = L.map(options.mapId, {
                doubleClickZoom: false,
            });

	        // Start get location
	        var lat_long = [];
			if ( typeof( navigator.geolocation ) !== 'undefined' && typeof( navigator.geolocation.watchPosition ) !== 'undefined' ) {
				// Show loading
				$.mobile.loading( "show", {
					text: $.mobile.loader.prototype.options.text,
					textVisible: $.mobile.loader.prototype.options.textVisible,
					theme: $.mobile.loader.prototype.options.theme,
					textonly: false,
					html: ''
				});
				var position = navigator.geolocation.getCurrentPosition(
					function (position) {
						console.log(position);
					}
				);
				lat_long = [position.coords.latitude, position.coords.longitude];
				_this.watch_id = navigator.geolocation.watchPosition(
					// Success
					function( position ){
						console.log(position);
						lat_long = [position.coords.latitude, position.coords.longitude];
						_this.setMarker( lat_long );
					},
					// Error
					function( error ){
						console.log(error);
						navigator.geolocation.clearWatch( _this.watch_id );
					},
					// Settings
					{ frequency: 3000, enableHighAccuracy: true}
				);

			} else{
				// set lat/long HaNoi
				lat_long = [21.0333, 105.85];
	        }
	        $.mobile.loading( "hide" );
            _this._map.setView(lat_long, 16);

            // set tile
            _this.setTile(this._map, options.tileUrl);

            // get current gps
            _this._map.locate({
                watch: false,
                locate: true,
                setView: true,
                enableHighAccuracy: true
            });
            _this._map.on('locationfound', function(location) {
				console.log(location, _this._map);

            });
        },

	    setMarker: function (lat_long) {
		    var _this    = this;
		    var lat_long = L.latLng(lat_long[0], lat_long[1]);

		    if(typeof(_this.marker) == 'undefined') {
			    _this.marker = L.dlnUserMarker(lat_long, {pulsing:true}).addTo(_this._map);
			    _this._map.setZoom(16);
		    }
		    _this.marker.setLatLng(lat_long);
	    },

        setPosUser:function(map, position){
            console.log(position);
        },

        getMap: function() {
            return this._map;
        },

        setTile: function(map, tileUrl) {
            this._tile = L.tileLayer(tileUrl, {
                attribution: 'DinhLN Hot Points',
                maxZoom: 20
            }).addTo(map);
        },

        getTile: function() {
            return this._tile;
        },
    });
})(window);
