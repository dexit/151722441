(function (window) {
    window.GeolocationThrottle = {
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
})(window);
Longitude.noGeoSupport = function () {
    this.failMessage("Your browser doesn't support geo coding. Time to upgrade?");
};
Longitude.failMessage = function (message) {
    alert(message);
};
Longitude.MapUser = Class.extend({
    init: function (map, userId, data, ownUser) {
        this.map = map;
        this.userId = userId;
        this.ownUser = ownUser || false;
        this.update(data);
        var mapUser = this;
        this.marker = new L.UserMarker(this.point, {
            pulsing: this.online,
            accuracy: this.accuracy,
            smallIcon: L.Browser.retina
        }).addTo(this.map)
            .bindLabel(this.getLabelContent(), {
                noHide: true,
                closeButton: true
            }).showLabel().on("click", function () {
                mapUser.toggleLabel();
            });
        setTimeout(function () {
            mapUser.marker.showLabel();
            $(mapUser.marker.label._container).click(function () {
                mapUser.toggleLabel();
            });
        }, 1);
        this.render();
    },
    toggleLabel: function () {
        if (this.marker.label) {
            if (!this.marker.label._map || !this.marker.label._map.hasLayer(this.marker.label)) {
                this.marker.showLabel();
            } else {
                this.marker.hideLabel();
            }
        }
    },
    update: function (data) {
        this.point = data.point;
        this.name = data.name;
        this.timesince = data.timesince;
        this.online = data.online;
        this.accuracy = data.accuracy;
    },
    render: function (point) {
        this.marker.setLatLng(this.point);
        this.marker.setAccuracy(this.accuracy);
        this.marker.label.setContent(this.getLabelContent());
        this.marker.label.setLatLng(this.point);
        this.marker.setPulsing(this.online);
    },
    getLabelContent: function () {
        var username = (this.ownUser ? this.name + " (you)" : this.name);
        if (this.online)
            return username + '<time class="online">Online</time>';
        else
            return username + "<time>" + this.timesince + "</time>";
    }
});
Longitude.Room = {
    map: null,
    watchId: null,
    users: {},
    ownUserId: null,
    init: function () {
        this.initMap();
        if (!navigator.geolocation) {
            Longitude.noGeoSupport();
        } else {
            this.startTracking();
            var update = function () {
                Longitude.Room.updateMap();
                setTimeout(update, 3000);
            }
            update();
        }
        if ($("#username-form").data("room-name-set") != "1")
            this.showUsernameDialog();
    },
    startTracking: function () {
        var watchId = GeolocationThrottle.watchPosition(function (position) {
            console.log("position:", position);
            var data = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
                accuracy: position.coords.accuracy
            };
            $.post("position/", data, function (response) {
                console.log("response:", response);
            });
        }, function () {
            Longitude.failMessage("You have to allow the website to know your location");
        }, {
            throttleTime: 3000,
            enableHighAccuracy: true
        });
    },
    updateMap: function () {
        $.get("position/", function (response) {
            for (var i = 0; i < response.length; i++) {
                Longitude.Room.addUser(response[i]);
            }
        });
    },
    addUser: function (data) {
        var newUser = false;
        if (!!this.users[data.id]) {
            var user = this.users[data.id];
            user.update(data);
            user.render();
        } else {
            var user = new Longitude.MapUser(this.map, data.id, data, data.id == this.ownUserId);
            this.users[data.id] = user;
            newUser = true;
        }
        if (newUser)
            Longitude.Room.autoZoomMarkers();
    },
    getOwnUser: function () {
        var id;
        for (id in this.users) {
            if (this.users[id].ownUser)
                return this.users[id];
        }
        return null;
    },
    autoZoomMarkers: function () {
        var bounds = new L.LatLngBounds();
        var map = this.map;
        var id;
        for (id in this.users) {
            bounds.extend(this.users[id].marker.getLatLng());
        }
        map.fitBounds(bounds);
        setTimeout(function () {
            map.zoomOut();
        }, 1000);
    },
    isWithinCircle: function (overlay, x, y) {
        var pos = overlay.offset();
        var centerX = pos.left + (overlay.width() / 2);
        var centerY = pos.top + (overlay.height() / 2);
        var radius = (overlay.width() / 2) - 9;
        var distance = Math.sqrt(Math.pow(x - centerX, 2) + Math.pow(y - centerY, 2));
        return distance < radius;
    },
    initMap: function () {
        if (!this.map) {
            var map = L.map('map', {
                zoomControl: false
            });
            L.tileLayer('http://tiles.lyrk.org/lr/{z}/{x}/{y}?apikey=7ff4f5151ed9474d81ba061fbfb85d3f', {
                attribution: 'Open Street Map. Tiles by Lyrk.de',
                detectRetina: false
            }).addTo(map);
            map.attributionControl.setPrefix('');
            this.map = map;
            var zoomFS = new L.Control.ZoomFS({
                position: "topright"
            });
            map.addControl(zoomFS);
            $(zoomFS._container).hide();
            var overlay = $(".overlay").enhance();
            var touchInfo = $(".overlay .touch-info");
            overlay.click(function (e) {
                if (Longitude.Room.isWithinCircle(overlay, e.pageX, e.pageY))
                    zoomFS.fullscreen();
            }).on("touchstart", function (e) {
                var orig = e.originalEvent;
                if (Longitude.Room.isWithinCircle(overlay, orig.changedTouches[0].pageX, orig.changedTouches[0].pageY))
                    touchInfo.show();
            }).on("touchend touchcancel mouseleave", function (e) {
                touchInfo.hide();
            });
            if (!("ontouchstart" in document.documentElement)) {
                touchInfo.html("Click for fullscreen");
                overlay.on("mousemove", function (e) {
                    if (Longitude.Room.isWithinCircle(overlay, e.pageX, e.pageY))
                        touchInfo.show();
                    else
                        touchInfo.hide();
                }).on("mouseleave", function (e) {
                    touchInfo.hide();
                });
            }
            map.on('enterFullscreen', function () {
                $(".overlay").hide();
                $(zoomFS._container).show();
            });
            map.on('exitFullscreen', function () {
                $(".overlay").show();
                $(zoomFS._container).hide();
            });
        }
        return this.map;
    },
    showUsernameDialog: function () {
        var dialog = $("#username-dialog");
        $("#username-form").enhance().submit(function (event) {
            event.preventDefault();
            $.post($(this).attr("action"), $(this).serialize(), function (response) {
                var ownUser = Longitude.Room.getOwnUser();
                if (ownUser) {
                    ownUser.name = $("#username-form").find("input[type='text']").val();
                    ownUser.render();
                }
                dialog.fadeOut();
            });
        });
        dialog.fadeIn();
    }
};
Longitude.ShareLink = {
    init: function () {
        var shareInput = $(".share input").enhance();
        var originalUrl = shareInput.val();
        shareInput.click(function () {
            this.setSelectionRange(0, 9999);
        }).change(function () {
            $(this).val(originalUrl);
        });
    }
};
Longitude.TouchHover = {
    init: function () {
        if ("ontouchstart" in document.documentElement) {
            $(".touch-hover").enhance().on("touchstart", function () {
                $(this).addClass("hover");
            }).on("touchmove touchend touchcancel", function () {
                $(this).removeClass("hover");
            });
        } else {
            $(".touch-hover").enhance().hover(function () {
                $(this).addClass("hover");
            }, function () {
                $(this).removeClass("hover");
            });
        }
    }
};
Longitude.Hud = {
    init: function () {
        if (navigator.userAgent.match(/iPad/i) != null) {
            $('meta[name=viewport]').attr("content", "width=639, initial-scale=1.2, maximum-scale=1.2, user-scalable=no");
        }
        $(".hud-bottom .button-hitbox").enhance().click(function () {
            $("#wrapper").toggleClass("black");
        });
    }
};