(function ($) {
    "use strict";

    var AdQuick = function () {
        var self = this;
        this.$allow = true;
        this.$lat = $('input[name="lat"]');
        this.$long = $('input[name="lng"]');
        this.$address = $('#dln_location');
        this.autocomplete_id = document.getElementById('dln_location');
        this.geocoder = null;
        this.autocomplete = null;
        this.latlng = new google.maps.LatLng(this.lat_val, this.long_val);
        this.s_placeholder = 'Nhập địa chỉ';

        this.initAutocomplete();
        this.initEvents();

        var self = this;
        $('#dln_track').on('click', function (e) {
            e.preventDefault();

            self.geolocate();
        });

        $('#dln_submit_quick').on('click', function (e) {
            e.preventDefault();

            if (self.$allow) {
                var data = $('#dln_frm_quick').serializeArray();
                if (data) {
                    self.$allow = false;
                    $.ajax({
                        type: 'POST',
                        url: window.root_url_api + '/ad/quick',
                        data: data,
                        success: function (res) {
                            self.$allow = true;
                            if (res.status == 'success') {
                                // Redirect to ad
                                window.location = window.root_url + '/tin/' + res.data;
                            }
                        },
                        error: function (data) {
                            self.$allow = true;
                            if (data.responseText) {
                                window.ad_common.showError(data.responseText);
                            } else {
                                console.log(data);
                            }
                        }
                    });
                }
            }
        });
    };

    AdQuick.prototype.initAutocomplete = function () {
        var self = this;

        self.autocomplete = new google.maps.places.Autocomplete(self.autocomplete_id, {
            types: ['geocode']
        });
    };

    AdQuick.prototype.initEvents = function () {
        var self = this;

        // For autocomplete
        google.maps.event.addListener(self.autocomplete, 'place_changed', function () {
            var place = self.autocomplete.getPlace();
            if (place.geometry) {
                self.$lat.val(place.geometry.location.lat());
                self.$long.val(place.geometry.location.lng());
            } else {
                self.$lat.val('');
                self.$long.val('');
            }
        });
    };

    AdQuick.prototype.geolocate = function () {
        var self = this;

        if (self.autocomplete) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    self.autocomplete.setBounds(circle.getBounds());
                });
            }
        }
    };

    $(document).ready(function () {
        var ad_quick = new AdQuick();
    });

}(window.jQuery));
