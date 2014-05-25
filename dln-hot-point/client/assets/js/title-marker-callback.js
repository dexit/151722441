/**
 * Created by DinhLN on 5/25/2014.
 */
(function(window) {
    L.titleLayerCalback = L.TileLayer.extend({
        includes: L.Mixin.Events,

        onAdd: function( map ){
            map.on("locationfound", function(location) {
                if (!this.marker)
                    this.marker = L.userMarker(location.latlng, {pulsing:true}).addTo(map);

                this.marker.setLatLng(location.latlng);
                this.marker.setAccuracy(location.accuracy);
            });
            map.locate({
                watch: false,
                locate: true,
                setView: true,
                enableHighAccuracy: true
            });
        }
    });
    L.titleLayerCalback = function (urlTemplate, options) {
        return new L.titleLayerCalback(urlTemplate, options);
    };
})(window);