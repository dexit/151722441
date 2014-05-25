/**
 * Created by DinhLN on 5/25/2014.
 */
(function(window){
    var DLN = DLN || {};

    window.DLN_Geo = {
        watchPosition: function (callback, errorCallback, options) {
            var throttleTime = (!options ? 0 : options.throttleTime || 0);
            var bufferedArguments = null;
            var lastCall = null;
            var timeoutToken = null;
            return navigator.geolocation.watchPosition(function () {
                bufferedArguments = arguments;
                if (!lastCall) {
                    lastCall = new Date();
                    callback.apply(this, arguments);
                } else if (!timeoutToken) {
                    if (new Date() - lastCall > throttleTime) {
                        lastCall = new Date();
                        callback.apply(this, arguments);
                    } else {
                        var that = this;
                        timeoutToken = setTimeout(function () {
                            lastCall = new Date();
                            callback.apply(that, bufferedArguments);
                            timeoutToken = null;
                        }, throttleTime - (new Date() - lastCall));
                    }
                } else {}
            }, errorCallback, options);
        }
    };

    DLN.MapUser = Class.extend({
        options: {
            mapId: 'map',
            tileUrl: 'http://{s}.tile.osm.org/{z}/{x}/{y}.png'
        },

        init: function(options){
            options = L.Util.setOptions(this, options);

            this._map = L.map(options.mapId);
            // set tile
            this.setTile(this._map, options.tileUrl);
            // get current gps
            if (!navigator.geolocation) {
                DLN.noGeoSupport();
            } else {
                
            }
        },

        getMap: function() {
            return this._map;
        },

        setTile: function(map, tileUrl) {
            this._tile = L.tileLayer(tileUrl, {
                attribution: 'DinhLN Hot Points',
                maxZoom: 18
            }).addTo(map);
        },

        getTile: function() {
            return this._tile;
        },


    });

})(window);
