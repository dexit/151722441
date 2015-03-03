/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


webpackJsonp([1], [function(a, b, c) {
    "use strict";
    angular.module("app", ["app.core", "app.calendar", "app.chart", "app.dashboard", "app.form", "app.mail", "app.page", "app.setting", "app.table", "app.ui"]);
    c(1), c(2), c(3), c(4), c(5), c(8), c(6), c(7), c(9), c(10), angular.element(document).ready(function() {
        angular.bootstrap(document, ["app"])
    })
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.core", ["ngCookies", "ngAnimate", "ngTouch", "ui.bootstrap", "ui.router", "ui.jq"]);
    c(29)(d), c(30)(d), c(31)(d), c(43)(d), c(44)(d), c(45)(d), c(46)(d), c(47)(d), c(32)(d), c(33)(d)
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.calendar", []);
    c(34)(d)
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.chart", []);
    c(35)(d)
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.dashboard", []);
    c(36)(d)
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.form", []);
    c(37)(d)
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.page", []);
    c(38)(d)
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.setting", []);
    c(39)(d)
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.mail", []);
    c(40)(d)
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.table", []);
    c(41)(d)
}, function(a, b, c) {
    "use strict";
    var d = angular.module("app.ui", []);
    c(42)(d)
}, , , , , , , , , , , , , , , , , , , function(a) {
    a.exports = function(a) {
        a.run(["$rootScope", "$state", "$stateParams", function(a, b, c) {
            a.$state = b, a.$stateParams = c
        }])
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, c, d, e, f, g, h) {
            a.controller = e.register, a.directive = f.directive, a.filter = g.register, a.factory = h.factory, a.provider = h.provider, a.service = h.service, a.constant = h.constant, a.value = h.value, c.otherwise("dashboard"), d.state("default", {
                "abstract": !0,
                url: "",
                templateUrl: "modules/core/views/layouts/default.html"
            }).state("minimal", {
                "abstract": !0,
                url: "",
                templateUrl: "modules/core/views/layouts/minimal.html"
            })
        }])
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.controller("coreSettingsCtrl", ["$scope", "$rootScope", "$window", "$timeout", "$cookies", "viewport", function(a, b, c, d, e, f) {
            a.core = {
                name: "Miveus",
                version: "0.0.1",
                settings: {
                    fullScreen: !1,
                    pageLoading: !1,
                    headerFixed: !0,
                    headerSearchForm: !1,
                    sidebarLeftOpen: !1,
                    sidebarLeftFixed: !1,
                    sidebarLeftCollapse: f.width() >= 768 && f.width() < 992 ? !0 : !1
                },
                screen: {
                    xs: f.width() < 768 ? !0 : !1,
                    sm: f.width() >= 768 && f.width() < 992 ? !0 : !1,
                    md: f.width() >= 992 && f.width() < 1200 ? !0 : !1,
                    lg: f.width() >= 1200 ? !0 : !1,
                    height: f.height(),
                    width: f.width()
                }
            }, b.$on("$stateChangeStart", function() {
                a.core.settings.sidebarLeftOpen = !1, a.core.settings.pageLoading = !0
            }), b.$on("$stateChangeSuccess", function() {
                a.core.settings.pageLoading = !1
            }), angular.element(c).on("resize", function() {
                d.cancel(a.resizing), a.resizing = d(function() {
                    a.core.screen.xs = f.width() < 768 ? !0 : !1, a.core.screen.sm = f.width() >= 768 && f.width() < 992 ? !0 : !1, a.core.screen.md = f.width() >= 992 && f.width() < 1200 ? !0 : !1, a.core.screen.lg = f.width() >= 1200 ? !0 : !1, a.core.screen.height = f.height(), a.core.screen.width = f.width()
                }, 100)
            })
        }])
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.filter("capitalize", function() {
            return function(a) {
                return a ? a.replace(/([^\W_]+[^\s-]*) */g, function(a) {
                    return a.charAt(0).toUpperCase() + a.substr(1).toLowerCase()
                }) : ""
            }
        })
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.factory("viewport", ["$window", function() {
            return {
                height: function() {
                    return window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight
                },
                width: function() {
                    return window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth
                }
            }
        }])
    }
}, function(a, b, c) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, d, e, f, g, h, i) {
            a.controller = f.register, a.directive = g.directive, a.filter = h.register, a.factory = i.factory, a.provider = i.provider, a.service = i.service, a.constant = i.constant, a.value = i.value, e.state("default.calendar", {
                url: "/calendar",
                templateUrl: "modules/calendar/views/fullcalendar.html",
                resolve: {
                    load: ["$q", "$rootScope", function(b) {
                        var d = b.defer();
                        return c.e(2, function() {
                            c(81)(a), c(48)(a), d.resolve()
                        }, 0), d.promise
                    }]
                }
            })
        }])
    }
}, function(a, b, c) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, d, e, f, g, h, i) {
            a.controller = f.register, a.directive = g.directive, a.filter = h.register, a.factory = i.factory, a.provider = i.provider, a.service = i.service, a.constant = i.constant, a.value = i.value, e.state("default.chart", {
                url: "/chart",
                template: '<div class="slide-down" data-ui-view></div>'
            }).state("default.chart.flot", {
                url: "/flot",
                templateUrl: "modules/chart/views/flot.html",
                resolve: {
                    load: ["$q", "$rootScope", function(b) {
                        var d = b.defer();
                        return c.e(3, function() {
                            c(82)(), c(49)(a), c(50)(a), c(51)(a), c(52)(a), c(53)(a), c(54)(a), c(55)(a), c(56)(a), d.resolve()
                        }, 0), d.promise
                    }]
                }
            }).state("default.chart.others", {
                url: "/others",
                templateUrl: "modules/chart/views/others.html",
                resolve: {
                    load: ["$q", "$rootScope", function(a) {
                        var b = a.defer();
                        return c.e(4, function() {
                            c(83)(), c(84)(), b.resolve()
                        }, 0), b.promise
                    }]
                }
            })
        }])
    }
}, function(a, b, c) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, d, e, f, g, h, i) {
            a.controller = f.register, a.directive = g.directive, a.filter = h.register, a.factory = i.factory, a.provider = i.provider, a.service = i.service, a.constant = i.constant, a.value = i.value, e.state("default.dashboard", {
                url: "/dashboard",
                templateUrl: "modules/dashboard/views/dashboard.html",
                resolve: {
                    load: ["$q", "$rootScope", function(b) {
                        var d = b.defer();
                        return c.e(5, function() {
                            c(82)(), c(85)(), c(57)(a), c(58)(a), c(59)(a), c(60)(a), d.resolve()
                        }, 0), d.promise
                    }]
                }
            })
        }])
    }
}, function(a, b, c) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, d, e, f, g, h, i) {
            a.controller = f.register, a.directive = g.directive, a.filter = h.register, a.factory = i.factory, a.provider = i.provider, a.service = i.service, a.constant = i.constant, a.value = i.value, d.when("/form/wizard", "form/wizard/basic"), e.state("default.form", {
                url: "/form",
                template: '<div class="slide-down" data-ui-view></div>'
            }).state("default.form.elements", {
                url: "/elements",
                templateUrl: "modules/form/views/elements.html",
                resolve: {
                    load: ["$q", "$rootScope", function(a) {
                        var b = a.defer();
                        return c.e(6, function() {
                            c(86)(), c(87)(), b.resolve()
                        }, 0), b.promise
                    }]
                }
            }).state("default.form.validation", {
                url: "/validation",
                templateUrl: "modules/form/views/validation.html"
            }).state("default.form.wizard", {
                url: "/wizard",
                templateUrl: "modules/form/views/wizard-index.html"
            }).state("default.form.wizard.basic", {
                url: "/basic",
                templateUrl: "modules/form/views/wizard-basic.html"
            }).state("default.form.wizard.medical", {
                url: "/medical",
                templateUrl: "modules/form/views/wizard-medical.html"
            }).state("default.form.wizard.suggestion", {
                url: "/suggestion",
                templateUrl: "modules/form/views/wizard-suggestion.html"
            }).state("default.form.wizard.finish", {
                url: "/finish",
                templateUrl: "modules/form/views/wizard-finish.html"
            }).state("default.form.upload", {
                url: "/upload",
                templateUrl: "modules/form/views/upload.html",
                resolve: {
                    load: ["$q", "$rootScope", function(b) {
                        var d = b.defer();
                        return c.e(7, function() {
                            c(88)(a), d.resolve()
                        }, 0), d.promise
                    }]
                }
            })
        }])
    }
}, function(a, b, c) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, d, e, f, g, h, i) {
            a.controller = f.register, a.directive = g.directive, a.filter = h.register, a.factory = i.factory, a.provider = i.provider, a.service = i.service, a.constant = i.constant, a.value = i.value, e.state("default.page", {
                url: "/page",
                template: '<div class="slide-down" data-ui-view></div>'
            }).state("minimal.page", {
                url: "/page",
                template: '<div class="slide-down" data-ui-view></div>'
            }).state("default.page.blank", {
                url: "/blank",
                templateUrl: "modules/page/views/blank.html"
            }).state("minimal.page.signin", {
                url: "/signin",
                templateUrl: "modules/page/views/signin.html"
            }).state("minimal.page.signup", {
                url: "/signup",
                templateUrl: "modules/page/views/signup.html"
            }).state("minimal.page.lostpassword", {
                url: "/lostpassword",
                templateUrl: "modules/page/views/lostpassword.html"
            }).state("default.page.profile", {
                url: "/profile",
                templateUrl: "modules/page/views/profile.html",
                resolve: {
                    load: ["$q", "$rootScope", function(b) {
                        var d = b.defer();
                        return c.e(9, function() {
                            c(61)(a), d.resolve()
                        }, 0), d.promise
                    }]
                }
            }).state("minimal.page.error", {
                url: "/error",
                templateUrl: "modules/page/views/error.html"
            })
        }])
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, c, d, e, f, g, h) {
            a.controller = e.register, a.directive = f.directive, a.filter = g.register, a.factory = h.factory, a.provider = h.provider, a.service = h.service, a.constant = h.constant, a.value = h.value, c.when("/setting", "setting/profile"), d.state("default.setting", {
                url: "/setting",
                templateUrl: "modules/setting/views/index.html"
            }).state("default.setting.profile", {
                url: "/profile",
                templateUrl: "modules/setting/views/profile.html"
            }).state("default.setting.account", {
                url: "/account",
                templateUrl: "modules/setting/views/account.html"
            }).state("default.setting.security", {
                url: "/security",
                templateUrl: "modules/setting/views/security.html"
            })
        }])
    }
}, function(a, b, c) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, d, e, f, g, h, i) {
            a.controller = f.register, a.directive = g.directive, a.filter = h.register, a.factory = i.factory, a.provider = i.provider, a.service = i.service, a.constant = i.constant, a.value = i.value, d.when("/mail", "mail/folder/inbox"), e.state("default.mail", {
                url: "/mail",
                templateUrl: "modules/mail/views/index.html",
                resolve: {
                    load: ["$q", "$rootScope", function(b) {
                        var d = b.defer();
                        return c.e(8, function() {
                            c(86)(), c(87)(), c(62)(a), c(63)(a), c(64)(a), c(65)(a), d.resolve()
                        }, 0), d.promise
                    }]
                }
            }).state("default.mail.compose", {
                url: "/compose",
                templateUrl: "modules/mail/views/compose.html"
            }).state("default.mail.folder", {
                url: "/folder",
                template: '<div class="slide-top" data-ui-view></div>'
            }).state("default.mail.folder.param", {
                url: "/{folder}",
                templateUrl: "modules/mail/views/lists.html"
            }).state("default.mail.label", {
                url: "/label",
                template: '<div class="slide-down" data-ui-view></div>'
            }).state("default.mail.label.param", {
                url: "/{label}",
                templateUrl: "modules/mail/views/lists.html"
            }).state("default.mail.view", {
                url: "/view",
                template: '<div class="slide-down" data-ui-view></div>'
            }).state("default.mail.view.param", {
                url: "/{view}",
                templateUrl: "modules/mail/views/view.html"
            })
        }])
    }
}, function(a, b, c) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, d, e, f, g, h, i) {
            a.controller = f.register, a.directive = g.directive, a.filter = h.register, a.factory = i.factory, a.provider = i.provider, a.service = i.service, a.constant = i.constant, a.value = i.value, e.state("default.table", {
                url: "/table",
                template: '<div class="slide-down" data-ui-view></div>'
            }).state("default.table.static", {
                url: "/static",
                templateUrl: "modules/table/views/static.html",
                resolve: {
                    load: ["$q", "$rootScope", function(a) {
                        var b = a.defer();
                        return c.e(10, function() {
                            c(84)(), b.resolve()
                        }, 0), b.promise
                    }]
                }
            }).state("default.table.datatable", {
                url: "/datatable",
                templateUrl: "modules/table/views/datatable.html",
                resolve: {
                    load: ["$q", "$rootScope", function(a) {
                        var b = a.defer();
                        return c.e(11, function() {
                            c(89)(), b.resolve()
                        }, 0), b.promise
                    }]
                }
            })
        }])
    }
}, function(a, b, c) {
    "use strict";
    a.exports = function(a) {
        a.config(["$locationProvider", "$urlRouterProvider", "$stateProvider", "$controllerProvider", "$compileProvider", "$filterProvider", "$provide", function(b, d, e, f, g, h, i) {
            a.controller = f.register, a.directive = g.directive, a.filter = h.register, a.factory = i.factory, a.provider = i.provider, a.service = i.service, a.constant = i.constant, a.value = i.value, e.state("default.ui", {
                url: "/ui",
                template: '<div class="slide-down" data-ui-view></div>'
            }).state("default.ui.buttons", {
                url: "/buttons",
                templateUrl: "modules/ui/views/buttons.html"
            }).state("default.ui.grids", {
                url: "/grids",
                templateUrl: "modules/ui/views/grids.html"
            }).state("default.ui.icons", {
                url: "/icons",
                templateUrl: "modules/ui/views/icons.html"
            }).state("default.ui.bootstrap", {
                url: "/bootstrap",
                templateUrl: "modules/ui/views/bootstrap.html",
                resolve: {
                    load: ["$q", "$rootScope", function(b) {
                        var d = b.defer();
                        return c.e(12, function() {
                            c(66)(a), c(67)(a), c(68)(a), c(69)(a), c(70)(a), c(71)(a), c(72)(a), c(73)(a), c(74)(a), c(75)(a), c(76)(a), c(77)(a), c(78)(a), c(79)(a), c(80)(a), d.resolve()
                        }, 0), d.promise
                    }]
                }
            }).state("default.ui.widgets", {
                url: "/widgets",
                templateUrl: "modules/ui/views/widgets.html"
            })
        }])
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.directive("fullScreen", ["$timeout", function(a) {
            return {
                restrict: "A",
                link: function(b, c) {
                    a(function() {
                        c.on("click", function() {
                            screenfull.enabled && screenfull.toggle()
                        }), document.addEventListener(screenfull.raw.fullscreenchange, function() {
                            b.$parent.core.settings.fullScreen = screenfull.isFullscreen ? !0 : !1
                        })
                    })
                }
            }
        }])
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.directive("indicator", ["$rootScope", "$timeout", function(a, b) {
            return {
                restrict: "A",
                replace: !0,
                templateUrl: "modules/core/views/partials/spinner.html",
                link: function(c, d) {
                    b(function() {
                        {
                            var b = angular.element(d).parent(".spinner-wrapper");
                            angular.element(d)
                        }
                        a.$on("$stateChangeStart", function() {
                            b.addClass("show")
                        }), a.$on("$stateChangeSuccess", function() {
                            b.removeClass("show")
                        })
                    })
                }
            }
        }])
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.directive("navSidebar", ["$timeout", function(a) {
            return {
                restrict: "C",
                scope: {},
                link: function(b, c) {
                    a(function() {
                        var a = !1,
                            b = function() {
                                var b = jQuery(this),
                                    f = b.parent(".nav-group"),
                                    g = b.next(".nav-submenu");
                                if (g.data("height", g.height()), f.hasClass("active")) {
                                    if (a) return !1;
                                    e(g, f)
                                } else {
                                    if (a) return !1;
                                    jQuery(c.children(".nav-group")).each(function(a, b) {
                                        jQuery(b).hasClass("active") && (jQuery(b).removeClass("active"), e(jQuery(b).children(".nav-submenu"), jQuery(b)))
                                    }), d(g, f)
                                }
                            },
                            d = function(b, c) {
                                b.css({
                                    height: 0
                                }).velocity({
                                    height: b.data("height")
                                }, {
                                    duration: 300,
                                    begin: function() {
                                        c.addClass("active"), a = !0
                                    },
                                    complete: function() {
                                        b.removeAttr("style"), a = !1
                                    }
                                }, "ease-in-out")
                            },
                            e = function(b, c) {
                                b.css({
                                    display: "block",
                                    height: b.data("height")
                                }).velocity({
                                    height: 0
                                }, {
                                    duration: 300,
                                    begin: function() {
                                        c.removeClass("active"), a = !0
                                    },
                                    complete: function() {
                                        b.removeAttr("style"), a = !1
                                    }
                                }, "ease-in-out")
                            };
                        c.on("click", ".nav-toggle", b)
                    })
                }
            }
        }])
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.directive("placeholder", ["$timeout", function(a) {
            var b = document.createElement("input");
            return "placeholder" in b ? {} : {
                restrict: "A",
                $scope: {},
                link: function(b, c, d) {
                    "password" !== d.type && a(function() {
                        c.val(d.placeholder), c.bind("focus", function() {
                            c.val() === d.placeholder && c.val("")
                        }).bind("blur", function() {
                            "" === c.val() && c.val(d.placeholder)
                        })
                    })
                }
            }
        }])
    }
}, function(a) {
    "use strict";
    a.exports = function(a) {
        a.value("slimScrollConfig", {}), a.directive("slimScroll", ["$timeout", "slimScrollConfig", function(a, b) {
            var c = {
                height: "",
                size: "6px",
                wrapperClass: "scroll-wrapper",
                railClass: "scroll-rail",
                barClass: "scroll-bar",
                wheelStep: 10,
                railVisible: !1
            };
            return b && angular.extend(c, b), {
                restrict: "A",
                link: function(b, d, e) {
                    a(function() {
                        if (!angular.element("html").hasClass("touch")) {
                            var a = angular.extend({}, c, b.$eval(e.slimScroll));
                            angular.element(d).slimScroll(a)
                        }
                    })
                }
            }
        }])
    }
}]);