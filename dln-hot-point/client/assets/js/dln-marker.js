/**
 * Created by DinhLN on 5/26/2014.
 */
(function(window) {
    var icon = L.divIcon({
        className: 'dln-usermarker',
        iconSize: [18, 18],
        iconAnchor: [9, 9],
        html: ''
    });

    var iconPulsing = L.divIcon({
        className: 'dln-usermarker',
        iconSize: [18, 18],
        iconAnchor: [9, 9],
        html: '<i class="marker"><b class="sonar"></b></i>'
    });

    L.DLN_UserMarker = L.Marker.extend({
        options: {
            pulsing: false,
            accuracy: 0,
        },

        initialize: function(latlng, options) {
            options = L.Util.setOptions(this, options);

            this.setPulsing(this.options.pulsing);
            // call super
            L.Marker.prototype.initialize.call(this, latlng, this.options);

            this.on("move", function() {
            }).on("remove", function() {
            });
        },

        setPulsing: function(pulsing) {
            this._pulsing = pulsing;

            this.setIcon(!!this._pulsing ? iconPulsing : icon);
        },

        onAdd: function(map) {
            // super
            L.Marker.prototype.onAdd.call(this, map);
        }
    });

    L.dlnUserMarker = function (latlng, options) {
        return new L.DLN_UserMarker(latlng, options);
    };
})(window);