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
            // set lat/long HaNoi
            _this._map.setView([21.0333, 105.85], 16);

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
                if(!_this.marker) {
                    _this.marker = L.dlnUserMarker(location.latlng, {pulsing:true}).addTo(_this._map);
                    _this._map.setZoom(16);
                }
                _this.marker.setLatLng(location.latlng);
            });
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
