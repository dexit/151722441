/**
 * Created by DinhLN on 5/25/2014.
 */
(function(window){
    DLN_Geo = function () {

    };

    DLN_Geo.prototype = {
        constructor: DLN_Geo,

        getCurrentPosition: function(callback) {
            var _this = this;
            if (navigator.geolocation) {
                var location_timeout = setTimeout(_this.noGeoSupport, 10000);

                navigator.geolocation.getCurrentPosition(function(position) {
                    clearTimeout(location_timeout);
                    console.log(position);
                    callback.apply(_this, position);
                }, function(error) {
                    clearTimeout(location_timeout);
                    _this.noGeoSupport();
                });
            }
        },

        noGeoSupport :function () {
            var _this = this;
            _this.failMessage("Thiết bị của bạn không hỗ trợ GPS, xin vui lòng nâng cấp lên thiết bị khác để sử dụng!");
        },

        failMessage: function(message) {
            alert(message);
            return false;
        }
    };
})(window);