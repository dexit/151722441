(function($) {
	"use strict";

	function Plugin(option) {
		return this.each(function() {
			var $this = $(this),
					data = $this.data("pg.sidebar"),
					options = "object" == typeof option && option;
			data || $this.data("pg.sidebar", data = new Sidebar(this, options)), "string" == typeof option && data[option]()
		})
	}
	var Sidebar = function(element, options) {
		function sidebarMouseEnter() {
			return $.Pages.isVisibleSm() || $.Pages.isVisibleXs() ? !1 : void($(".close-sidebar").data("clicked") || _this.$body.hasClass("menu-pin") || (_this.cssAnimation ? (_this.$element.css({
				transform: _this.menuOpenCSS
			}), _this.$body.addClass("sidebar-visible")) : _this.$element.stop().animate({
				left: "0px"
			}, 400, $.bez(_this.bezierEasing), function() {
				_this.$body.addClass("sidebar-visible")
			})))
		}

		function sidebarMouseLeave(e) {
			if ($.Pages.isVisibleSm() || $.Pages.isVisibleXs()) return !1;
			if ("undefined" != typeof e) {
				var target = $(e.target);
				if (target.parent(".page-sidebar").length) return
			}
			_this.$body.hasClass("menu-pin") || ($(".sidebar-overlay-slide").hasClass("show") && ($(".sidebar-overlay-slide").removeClass("show"), $("[data-pages-toggle']").removeClass("active")), _this.cssAnimation ? (_this.$element.css({
				transform: _this.menuClosedCSS
			}), _this.$body.removeClass("sidebar-visible")) : _this.$element.stop().animate({
				left: "-" + _this.sideBarWidthCondensed + "px"
			}, 400, $.bez(_this.bezierEasing), function() {
				_this.$body.removeClass("sidebar-visible"), setTimeout(function() {
					$(".close-sidebar").data({
						clicked: !1
					})
				}, 100)
			}))
		}
		if (this.$element = $(element), this.options = $.extend(!0, {}, $.fn.sidebar.defaults, options), this.bezierEasing = [.05, .74, .27, .99], this.cssAnimation = !0, this.menuClosedCSS, this.menuOpenCSS, this.css3d = !0, this.sideBarWidth = 280, this.sideBarWidthCondensed = 210, this.$sidebarMenu = this.$element.find(".sidebar-menu > ul"), this.$pageContainer = $(this.options.pageContainer), this.$body = $("body"), this.$sidebarMenu.length) {
			"desktop" == $.Pages.getUserAgent() && this.$sidebarMenu.scrollbar({
				ignoreOverlay: !1
			}), Modernizr.csstransitions || (this.cssAnimation = !1), Modernizr.csstransforms3d || (this.css3d = !1), this.menuOpenCSS = 1 == this.css3d ? "translate3d(" + this.sideBarWidthCondensed + "px, 0,0)" : "translate(" + this.sideBarWidthCondensed + "px, 0)", this.menuClosedCSS = 1 == this.css3d ? "translate3d(0, 0,0)" : "translate(0, 0)", this.$sidebarMenu.find("li > a").on("click", function() {
				if ($(this).parent().children(".sub-menu") !== !1) {
					{
						var parent = $(this).parent().parent();
						$(this).parent()
					}
					parent.children("li.open").children("a").children(".arrow").removeClass("open"), parent.children("li.open").children("a").children(".arrow").removeClass("active"), parent.children("li.open").children(".sub-menu").slideUp(200, function() {}), parent.children("li").removeClass("open");
					var sub = $(this).parent().children(".sub-menu");
					sub.is(":visible") ? ($(".arrow", $(this)).removeClass("open"), sub.slideUp(200, function() {
						$(this).parent().removeClass("active")
					})) : ($(".arrow", $(this)).addClass("open"), $(this).parent().addClass("open"), sub.slideDown(200, function() {}))
				}
			}), $(".sidebar-slide-toggle").on("click touchend", function(e) {
				e.preventDefault(), $(this).toggleClass("active");
				var el = $(this).attr("data-pages-toggle");
				null != el && $(el).toggleClass("show")
			});
			var _this = this;
			this.$element.bind("hover", sidebarMouseEnter), this.$pageContainer.bind("mouseover", sidebarMouseLeave)
		}
	};
	Sidebar.prototype.toggleSidebar = function() {
		var timer;
		this.$body.hasClass("sidebar-open") ? (this.$body.removeClass("sidebar-open"), timer = setTimeout(function() {
			this.$element.removeClass("visible")
		}.bind(this), 400)) : (clearTimeout(timer), this.$element.addClass("visible"), setTimeout(function() {
			this.$body.addClass("sidebar-open")
		}.bind(this), 10))
	}, Sidebar.prototype.togglePinSidebar = function(toggle) {
		"hide" == toggle ? this.$body.removeClass("menu-pin") : "show" == toggle ? this.$body.addClass("menu-pin") : this.$body.toggleClass("menu-pin")
	};
	var old = $.fn.sidebar;
	$.fn.sidebar = Plugin, $.fn.sidebar.Constructor = Sidebar, $.fn.sidebar.defaults = {
		pageContainer: ".page-container"
	}, $.fn.sidebar.noConflict = function() {
		return $.fn.sidebar = old, this
	}, $(window).on("load", function() {
		$('[data-pages="sidebar"]').each(function() {
			var $sidebar = $(this);
			$sidebar.sidebar($sidebar.data())
		})
	}), $(document).on("click.pg.sidebar.data-api", '[data-toggle-pin="sidebar"]', function(e) {
		e.preventDefault();
		var $target = ($(this), $('[data-pages="sidebar"]'));
		return $target.data("pg.sidebar").togglePinSidebar(), !1
	}), $(document).on("click.pg.sidebar.data-api touchstart", '[data-toggle="sidebar"]', function(e) {
		e.preventDefault();
		var $target = ($(this), $('[data-pages="sidebar"]'));
		return $target.data("pg.sidebar").toggleSidebar(), !1
	})
}(window.jQuery));