(function ($) {
    "use strict";
    
    var Notification = function(container, options) {
        function SimpleNotification() {
            if (self.notification.addClass("pgn-simple"), self.alert.append(self.options.message), self.options.showClose) {
                var close = $('<button type="button" class="close" data-dismiss="alert"></button>').append('<span aria-hidden="true">&times;</span>').append('<span class="sr-only">Close</span>');
                self.alert.prepend(close)
            }
        }

        function BarNotification() {
            if (self.notification.addClass("pgn-bar"), self.alert.append("<span>" + self.options.message + "</span>"), self.alert.addClass("alert-" + self.options.type), self.options.showClose) {
                var close = $('<button type="button" class="close" data-dismiss="alert"></button>').append('<span aria-hidden="true">&times;</span>').append('<span class="sr-only">Close</span>');
                self.alert.prepend(close)
            }
        }

        function CircleNotification() {
            self.notification.addClass("pgn-circle");
            var table = "<div>";
            self.options.thumbnail && (table += '<div class="pgn-thumbnail"><div>' + self.options.thumbnail + "</div></div>"), table += '<div class="pgn-message"><div>', self.options.title && (table += '<p class="bold">' + self.options.title + "</p>"), table += "<p>" + self.options.message + "</p></div></div>", table += "</div>", self.options.showClose && (table += '<button type="button" class="close" data-dismiss="alert">', table += '<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>', table += "</button>"), self.alert.append(table), self.alert.after('<div class="clearfix"></div>')
        }

        function FlipNotification() {
            if (self.notification.addClass("pgn-flip"), self.alert.append("<span>" + self.options.message + "</span>"), self.options.showClose) {
                var close = $('<button type="button" class="close" data-dismiss="alert"></button>').append('<span aria-hidden="true">&times;</span>').append('<span class="sr-only">Close</span>');
                self.alert.prepend(close)
            }
        }
        var self = this;
        return self.container = $(container), self.notification = $('<div class="pgn"></div>'), self.options = $.extend(!0, {}, $.fn.pgNotification.defaults, options), self.container.find(".pgn-wrapper[data-position=" + this.options.position + "]").length ? self.wrapper = $(".pgn-wrapper[data-position=" + this.options.position + "]") : (self.wrapper = $('<div class="pgn-wrapper" data-position="' + this.options.position + '"></div>'), self.container.append(self.wrapper)), self.alert = $('<div class="alert"></div>'), self.alert.addClass("alert-" + self.options.type), "bar" == self.options.style ? new BarNotification : "flip" == self.options.style ? new FlipNotification : "circle" == self.options.style ? new CircleNotification : ("simple" == self.options.style, new SimpleNotification), self.notification.append(self.alert), self.alert.on("closed.bs.alert", function() {
            self.notification.remove(), self.options.onClosed()
        }), this
    };
    Notification.VERSION = "1.0.0", Notification.prototype.show = function() {
        this.wrapper.prepend(this.notification), this.options.onShown(), 0 != this.options.timeout && setTimeout(function() {
            this.notification.fadeOut("slow", function() {
                $(this).remove(), this.options.onClosed()
            })
        }.bind(this), this.options.timeout)
    }, $.fn.pgNotification = function(options) {
        return new Notification(this, options)
    }, $.fn.pgNotification.defaults = {
        style: "simple",
        message: null,
        position: "top-right",
        type: "info",
        showClose: !0,
        timeout: 4e3,
        onShown: function() {},
        onClosed: function() {}
    }

}(window.jQuery));