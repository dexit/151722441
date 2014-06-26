/**
 * Created by DinhLN on 5/25/2014.
 */
(function(window){
	var DLN = DLN || {};
	DLN_MapUser = Class.extend({
		options: {
			mapId: 'dln_map',
			//tileUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png',
			tileUrl: 'http://mt1.google.com/vt/lyrs=m@110&hl=pl&x={x}&y={y}&z={z}'
		},

		init: function(options){
			var _this = this;
			options = L.Util.setOptions(this, options);

			_this._map = L.map(options.mapId, {
				doubleClickZoom: false,
				minZoom: 1,
				maxZoom: 19,
				fadeAnimation: true,
				zoomAnimation: true,
				markerZoomAnimation: true,
			});
			// set lat/long HaNoi
			_this._map.setView([21.0333, 105.85], 16);

			// set tile
			_this.setTile(this._map, options.tileUrl);

			$.mobile.loading( "show", {
				text: $.mobile.loader.prototype.options.text,
				textVisible: $.mobile.loader.prototype.options.textVisible,
				theme: $.mobile.loader.prototype.options.theme,
				textonly: false,
				html: ''
			});

			_this._map.on('latlng', function () {
				console.log('latlng');
			});

			// get current gps
			_this._map.locate({
				watch: false,
				locate: true,
				setView: true,
				enableHighAccuracy: true
			});

			_this._map.on('locationfound', function(location) {
				// Cache last latlong
				if (location.latlng) {
					_this.cache_latlng = location.latlng;
				}
				if(!_this.marker) {
					_this.marker = L.dlnUserMarker(location.latlng, {pulsing:true}).addTo(_this._map);
					_this._map.setZoom(16);
				}
				_this.marker.setLatLng(location.latlng);

				$.mobile.loading( "hide" );

				$('body').trigger('on_load_backbone');
			});
		},

		setCenterView: function() {
			var _this = this;
			if ( _this.cache_latlng ) {
				_this.map.setView( _this.cache_latlng );
			}
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
				maxZoom: 19,
				errorTileUrl: '/dln.png',
			}).addTo(map);
		},

		getTile: function() {
			return this._tile;
		},
	});

	DLN_MapUser.getInstance = function () {
		if (DLN_MapUser.instance == undefined) DLN_MapUser.instance = new DLN_MapUser();
		return DLN_MapUser.instance;
	};
})(window);
