'use strict';

/**
 * @ngdoc overview
 * @name fbFeedsApp
 * @description
 * # fbFeedsApp
 *
 * Main module of the application.
 */
angular
  .module('fbFeedsApp', [
    'ngAnimate',
    'ngCookies',
    'ngRoute',
    'ngSanitize',
    'ngCordova',
    'ionic',
    'angularMoment',
    'infinite-scroll',
    'LocalStorageModule'
  ])
  .config(["$stateProvider", "$urlRouterProvider", "localStorageServiceProvider", "$httpProvider", function ($stateProvider, $urlRouterProvider, localStorageServiceProvider, $httpProvider) {
    $httpProvider.defaults.useXDomain = true;
    //$httpProvider.defaults.headers.common['X-Requested-With'];
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';

    document.addEventListener('deviceready', function () {
      var admobid = {};
      if (/(android)/i.test(navigator.userAgent)) { // for android
        admobid = {
          banner: 'ca-app-pub-9356823423719215/3164925682',
          interstitial: 'ca-app-pub-xxx/yyy'
        };
      } else if (/(ipod|iphone|ipad)/i.test(navigator.userAgent)) { // for ios
        admobid = {
          banner: 'ca-app-pub-9356823423719215/2268445281',
          interstitial: 'ca-app-pub-xxx/kkk'
        };
      } else {
        admobid = {
          banner: 'ca-app-pub-9356823423719215/3164925682',
          interstitial: 'ca-app-pub-xxx/yyy'
        };
      }

      // Run admob
      if (AdMob) {
        AdMob.createBanner({
          adId: admobid.banner,
          overlap: true,
          position: AdMob.AD_POSITION.BOTTOM_CENTER,
          autoShow: false});
      }

      // Show ad for 30s
      var showAd = function () {
        AdMob.showBanner(AdMob.AD_POSITION.BOTTOM_CENTER);
        var timeOut = setTimeout(function () {
          AdMob.hideBanner();
        }, 6000);
      };

      // Show first time.
      showAd();

      var timeInterval = setInterval(showAd, 18000);
    }, false);

    $stateProvider
      .state('app', {
        url: '/',
        abstract: true,
        templateUrl: 'views/app.html',
        controller: 'AppCtrl'
      })
      .state('app.feeds', {
        url: 'feeds',
        views: {
          'appContent': {
            templateUrl: 'views/feeds.html',
            controller: 'FeedsCtrl'
          }
        }
      })
      .state('app.pages', {
        url: 'pages',
        views: {
          'appContent': {
            templateUrl: 'views/pages.html',
            controller: 'PagesCtrl'
          }
        }
      })
      .state('app.page', {
        url: 'pages/:pageId',
        views: {
          'appContent': {
            templateUrl: 'views/page.html',
            controller: 'PageCtrl'
          }
        }
      })
      .state('app.page_vote', {
        url: 'page/vote/{fbId}',
        views: {
          'appContent': {
            templateUrl: 'views/page-vote.html',
            controller: 'PageVoteCtrl'
          }
        }
      })
      .state('app.page_vote_search', {
        url: 'page/vote_search',
        views: {
          'appContent': {
            templateUrl: 'views/page-vote-search.html',
            controller: 'PageVoteSearchCtrl'
          }
        }
      })
      .state('app.category_filter', {
        url: 'category_filter',
        views: {
          'appContent': {
            templateUrl: 'views/category-filter.html',
            controller: 'CategoryFilterCtrl'
          }
        }
      })
      .state('app.category', {
        url: 'category',
        views: {
          'appContent': {
            templateUrl: 'views/category.html',
            controller: 'CategoryCtrl'
          }
        }
      })
      .state('app.page_category', {
        url: 'category/:categoryId',
        views: {
          'appContent': {
            templateUrl: 'views/pages.html',
            controller: 'PagesCtrl'
          }
        }
      })
      .state('app.about', {
        url: 'about',
        views: {
          'appContent': {
            templateUrl: 'views/about.html',
            controller: 'AboutCtrl'
          }
        }
      });

    // if none of the above states are matched, use this as the fallback
    $urlRouterProvider.otherwise('/feeds');

    localStorageServiceProvider
      .setPrefix('fbFeedsApp')
      .setStorageCookie(3, '/')
      .setStorageType('sessionStorage')
      .setStorageCookieDomain('http://vivufb.com')
      .setNotify(true, true);

  }])
  .run(["$rootScope", "$ionicPlatform", "$ionicLoading", "$cordovaAppAvailability", "$cordovaDevice", "$state", "$window", function ($rootScope, $ionicPlatform, $ionicLoading, $cordovaAppAvailability, $cordovaDevice, $state, $window) {

    $rootScope.state = $state;

    /* Get width of windows */
    $rootScope.mainWidth = $window.innerWidth;

    /* Get UUID */
    try {
      $rootScope.uuid = $cordovaDevice.getUUID();
    } catch (err) {
      $rootScope.uuid = 'Simulator';
    }

    $rootScope.slideHeader = false;
    $rootScope.slideHeaderPrevious = 0;

    $ionicPlatform.ready(function () {
      // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
      // for form inputs)
      if (window.cordova && window.cordova.plugins.Keyboard) {
        cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
      }
      if (window.StatusBar) {
        // org.apache.cordova.statusbar required
        StatusBar.styleDefault();
      }
    });

    $rootScope.showLoading = function (message) {
      $ionicLoading.show({
        template: message
      });
    };

    $rootScope.hideLoading = function () {
      $ionicLoading.hide();
    };

    $rootScope.gotoLink = function (url) {
      if ($rootScope.allowScheme) {
        window.open(url, '_system', 'location=yes,toolbar=yes');
      } else {
        window.open(url, '_blank');
      }
    };

    $rootScope.$on('ngRepeatFinished', function () {
      $('img.lazy-images:not(.active)').each(function () {
        $(this).lazyload({
          effect: 'fadeIn',
          skip_invisible: false
        });
        $(this).on('appear', function () {
          if ($(this).hasClass('dln-thumb-images')) {
            var height = $(this).height();
            var width = $(this).width();
            if (height && width) {
              $(this).closest('.dln-image-thumb').find('i.icon').css({
                'display': 'block'
              });
            }
          }
        });
        $(this).trigger('appear');
        $(this).addClass('active');
      });
    });

    document.addEventListener('deviceready', function () {
      var scheme;
      if (device.platform === 'iOS') {
        scheme = 'fb://';
      }
      else if (device.platform === 'Android') {
        scheme = 'com.facebook.katana';
      }

      $cordovaAppAvailability.check(scheme)
        .then(function () {
          $rootScope.allowScheme = true;
        }, function () {
          $rootScope.allowScheme = false;
        });

    }, false);

  }]);

'use strict';

/**
 * @ngdoc service
 * @name fbFeedsApp.appGlobal
 * @description
 * # appGlobal
 * Constant in the fbFeedsApp.
 */
angular.module('fbFeedsApp')
  .constant('appGlobal', {
    host: 'http://tintuc.vivufb.com/api/v1'
  });

'use strict';

/**
 * @ngdoc service
 * @name fbFeedsApp.fCache
 * @description
 * # fCache
 * Factory in the fbFeedsApp.
 */
angular.module('fbFeedsApp')
  .factory('fCache', ["$http", "$rootScope", "appGlobal", function ($http, $rootScope, appGlobal) {

    var cache = {};

    /* Public API here */
    return {

      /* Initialize factory */
      init: function (next) {
        if (! angular.equals({}, cache)) {
          next();
          return;
        }

        /* Get cache from server */
        var url = appGlobal.host + '/cache';
        $rootScope.showLoading('Đang tải...');
        $http.get(url)
          .success(function (resp) {
            $rootScope.hideLoading();
            if (resp.status === 'success') {
              cache.categories = resp.data.category;
              cache.pages = resp.data.page;
              next();
            }
          })
          .error(function (data, status, headers, config) {
            console.log(data, status, headers, config);
            $rootScope.hideLoading();
          });

        return cache;
      },

      /* Find page by id */
      findPageById: function (id) {
        var _return = null;
        angular.forEach(cache.pages, function (item) {
          if (item.id === id) {
            _return = item;
          }
        });

        return _return;
      },

      /* Find category by id */
      findCategoryById: function (id) {
        var _return = null;

        angular.forEach(cache.categories, function (item) {
          if (item.id === id) {
            _return = item;
          }
        });

        return _return;
      },

      /* Get pages */
      getPages: function () {
        return cache.pages;
      },

      /* Get categories */
      getCategories: function () {
        return cache.categories;
      }

    };
  }]);

'use strict';

/**
 * @ngdoc filter
 * @name fbFeedsApp.filter:nThousand
 * @function
 * @description
 * # nThousand
 * Filter in the fbFeedsApp.
 */
angular.module('fbFeedsApp')
  .filter('nThousand', function () {
    return function(input) {
      var num = parseFloat(input);
      if (num >= 1000000000) {
        return (num / 1000000000).toFixed(1) + 'g';
      }
      if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'm';
      }
      if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'k';
      }
      return num;
    };
  });

'use strict';

/**
 * @ngdoc directive
 * @name fbFeedsApp.directive:onLastRepeat
 * @description
 * # onLastRepeat
 */
angular.module('fbFeedsApp')
  .directive('onLastRepeat', ["$timeout", function ($timeout) {
    return {
      restrict: 'A',
      link: function (scope) {
        if (scope.$last === true) {
          $timeout(function () {
            scope.$emit('ngRepeatFinished');
          });
        }
      }
    };
  }]);

'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:AppCtrl
 * @description
 * # AppCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('AppCtrl', ["$scope", "$rootScope", function ($scope, $rootScope) {

    $scope.init = function () {
      $rootScope.feedType = 'new';

      $('#dln_tab_feed .tab-item').on('click', function (e) {
        e.preventDefault();

        $('.tab-item.active').removeClass('active');
        $(this).addClass('active');
        $rootScope.feedType = $(this).data('type');
        $rootScope.$emit('onFeedRefreshFeeds', null);
      });
    };
    $scope.init();

  }]);

'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:CategoryFilterCtrl
 * @description
 * # CategoryFilterCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('CategoryFilterCtrl', ["$scope", "$rootScope", "$http", "$ionicHistory", "appGlobal", "localStorageService", function ($scope, $rootScope, $http, $ionicHistory, appGlobal, localStorageService) {
    $scope.categories = [];
    var isSupported = false;
    var page = 0;
    var dln_category_ids = 'dln_category_ids';
    var dln_category_cache = 'dln_category_cache';
    var category_ids = '';

    $scope.gotoFeeds = function () {
      var category_ids_selected = [];
      $('#dln_category_filter input:checked').each(function () {
        category_ids_selected.push($(this).val());
      });

      if (! angular.equals(category_ids_selected, category_ids)) {
        if (localStorageService.isSupported) {
          localStorageService.set(dln_category_ids, category_ids_selected);
        }

        $rootScope.$emit('onFeedRefreshFeeds', null);
      }

      $ionicHistory.goBack();
    };

    $scope.parseObj = function (data) {
      angular.forEach(data, function (item) {
        item.checked = false;

        angular.forEach(category_ids, function (cat) {
          if (item.id === cat) {
            item.checked = true;
          }
        });

        $scope.categories.push(item);
      });

      $rootScope.hideLoading();
    };

    $scope.getCategory = function () {
      // Check category exists in cache
      if (isSupported && localStorageService.get(dln_category_cache)) {
        var category_cache = localStorageService.get(dln_category_cache);
        var data = null;
        if (typeof(category_cache) === 'string') {
          data = JSON.parse(dln_category_cache);
        } else {
          data = category_cache;
        }

        $scope.parseObj(data);
      } else {
        $http.get(appGlobal.host + '/category?page=' + page)
          .success(function (resp) {
            $scope.loading = false;
            if (resp.status === 'success') {
              localStorageService.set(dln_category_cache, JSON.stringify(resp.data));

              $scope.parseObj(resp.data);
            }
            page += 1;
          })
          .error(function (data, status, headers, config) {
            $scope.loading = false;
            console.log(data, status, headers, config);
            $rootScope.hideLoading();
          });
      }
    };

    $scope.$on('$ionicView.enter', function (e, args) {
      $rootScope.showLoading();
      isSupported = localStorageService.isSupported;
      if (isSupported) {
        category_ids = localStorageService.get(dln_category_ids);
      }
      $scope.getCategory();
    });
  }]);

'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:FeedsCtrl
 * @description
 * # FeedsCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('FeedsCtrl', ["$scope", "$rootScope", "$location", "fCache", "sFeed", function ($scope, $rootScope, $location, fCache, sFeed) {

    $scope.feeds = [];
    $scope._page = 0;
    $scope.last_request = '';
    $scope.loading = true;
    $scope.indexPos = 0;

    $scope.gotoPage = function (index) {
      if (! $scope.feeds[index].page) {
        return false;
      }

      $location.path('/pages/' + $scope.feeds[index].page.id);
    };

    $scope.setFeeds = function (feeds) {
      $scope.feeds = feeds;
    };

    $scope.scollGetFeeds = function () {
      sFeed.getFeeds($scope);
    };

    $scope.init = function () {
      fCache.init(function () {
        $scope.loading = false;
        sFeed.getFeeds($scope);
      });
    };
    $scope.init();

    $scope.$on('$ionicView.enter', function () {
      $('#dln_tab_feed').show();
    });

    $scope.$on('$ionicView.leave', function () {
      $('#dln_tab_feed').hide();
    });

    $rootScope.$on('onFeedRefreshFeeds', function (e, args) {
      $scope._page = 0;
      $scope.last_request = '';
      sFeed.getFeeds($scope, true);
    });

  }]);

'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PageDetailCtrl
 * @description
 * # PageDetailCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PageCtrl', ["$scope", "$http", "$stateParams", "$rootScope", "$location", "localStorageService", "fCache", "sFeed", function ($scope, $http, $stateParams, $rootScope, $location, localStorageService, fCache, sFeed) {
    $scope.page = null;
    $scope.category = null;
    $scope.feeds = [];
    $scope._page = 0;
    $scope.last_request = '';
    $scope.loading = false;

    /*$scope.getPage = function (id) {
      if (!id) {
        return false;
      }

      $rootScope.showLoading('Đang tải...');
      var url = appGlobal + '/pages/' + id;
      $http.get(url)
        .success(function (resp) {
          $scope.loading = false;

          if (resp.status === 'success') {
            $scope.page = resp.data;
          }
          $rootScope.hideLoading();
        })
        .error(function (data, status, headers, config) {
          $scope.loading = false;
          console.log(data, status, headers, config);
          window.alert('Không thể lấy tin, xin vui lòng thử lại!');
          $rootScope.hideLoading();
          if ($done) {
            $done();
          }
        });
    };*/

    $scope.scollGetFeeds = function () {
      sFeed.getFeeds($scope);
    };

    $scope.setFeeds = function (feeds) {
      $scope.feeds = feeds;
    };

    $scope.gotoPageLink = function () {
      var url = '';
      if ($rootScope.allowScheme) {
        url = $scope.page.app_page_link;
      } else {
        url = $scope.page.page_link;
      }

      $rootScope.gotoLink(url);
    };

    $scope.init = function () {
      if (! $stateParams.pageId) {
        $location.href = '/feeds';
      }

      localStorageService.set('dln_category_ids', null);

      fCache.init(function () {
        $scope.page = fCache.findPageById($stateParams.pageId);
        $scope.category = fCache.findCategoryById($scope.page.category_id);

        $scope.loading = false;
        $scope.page_id = $stateParams.pageId;
        sFeed.getFeeds($scope);
      });
    };
    $scope.init();

  }]);

'use strict';

/**
 * @ngdoc service
 * @name fbFeedsApp.shareParams
 * @description
 * # shareParams
 * Service in the fbFeedsApp.
 */
angular.module('fbFeedsApp')
  .service('shareParams', function () {
    var data = {
      page: '',
      category: '',
      refreshFeed: false,
      vote: ''
    };
    return {
      setVote: function (_value) {
        data.vote = _value;
      },

      getVote: function () {
        return data.vote;
      },

      setRefreshFeed: function (_value) {
        data.refreshFeed = _value;
      },

      getRefreshFeed: function () {
        return data.refreshFeed;
      },

      getCategory: function () {
        return data.category;
      },

      setCategory: function (obj) {
        data.category = obj;
      },

      getPage: function () {
        return data.page;
      },

      setPage: function(object) {
        data.page = object;
      }
    };
  });

'use strict';

/**
 * @ngdoc service
 * @name fbFeedsApp.sFeed
 * @description
 * # sFeed
 * Service in the fbFeedsApp.
 */
angular.module('fbFeedsApp')
  .service('sFeed', ["$rootScope", "$http", "appGlobal", "fCache", "localStorageService", function ($rootScope, $http, appGlobal, fCache, localStorageService) {

    this.toTimeZone = function (time) {
      return moment(time).add(7, 'hours');
    };

    this.getFeeds = function (_scope, isRefreshed) {
      var self = this;
      if (_scope.loading) {
        return;
      }

      /* Get category_ids */
      var category_ids = [];
      if (localStorageService.isSupported && localStorageService.get('dln_category_ids')) {
        category_ids = localStorageService.get('dln_category_ids');
      }

      /* Get page id */
      var page_id = 0;
      if (_scope.page_id) {
        page_id = _scope.page_id;
      }

      var type = $rootScope.feedType;

      /* Abort last request same */
      var url = appGlobal.host + '/feeds?page=' + _scope._page + '&category_ids=' + category_ids.join(',') + '&page_id=' + page_id + '&order=' + type;

      if (_scope.last_request !== '' && _scope.last_request === url) {
       return;
      }

      if (isRefreshed) {
        _scope.feeds = [];
      }

      $rootScope.showLoading('Đang tải...');

      _scope.last_request = url;
      $http.get(url)
        .success(function (resp) {
          _scope.loading = false;

          if (resp.status === 'success') {

            angular.forEach(resp.data, function (item, index) {
              /*if (index % 4 == 0) {
               var _new = {};
               _new.type = 'ads';
               _new.name = 'Test';
               _scope.feeds.push(_new);
               }*/
              /* Get page and category from cache */
              item.page = fCache.findPageById(item.page_id);
              item.category = fCache.findCategoryById(item.category_id);

              var obj = {};
              obj.created_at = self.toTimeZone(item.created_at);
              if ($rootScope.allowScheme) {
                obj.link = item.app_link;
                obj.page_link = item.page.app_page_link;
              } else {
                obj.link = item.link;
                obj.page_link = item.page.page_link;
              }
              switch (item.type) {
                case 'photo':
                  obj.font_type = 'fa fa-camera-retro';
                  break;
                case 'video':
                  obj.font_type = 'fa fa-play-circle';
                  break;
                case 'link':
                  obj.font_type = 'fa fa-unlink';
                  break;
                case 'status':
                  obj.font_type = 'fa fa-newspaper-o';
                  break;
              }

              _scope.feeds.push(angular.extend({}, item, obj));
            });

          }
          $rootScope.hideLoading();
          _scope._page += 1;
        })
        .error(function (data, status, headers, config) {
          _scope.loading = false;

          console.log(data, status, headers, config);
          window.alert('Không thể lấy tin, xin vui lòng thử lại!');
          $rootScope.hideLoading();

        });
    };

  }]);

'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PagesCtrl
 * @description
 * # PagesCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PagesCtrl', ["$scope", "$rootScope", "$stateParams", "$location", "fCache", function ($scope, $rootScope, $stateParams, $location, fCache) {
    $scope.pages = [];
    $scope._page = 0;
    $scope._lastRequest = '';
    $scope._loading = true;

    $scope.gotoPage = function (index) {
      if (! $scope.pages[index]) {
        return false;
      }

      $location.path('/pages/' + $scope.pages[index].id);
    };

    $scope.gotoFBLink = function (index) {
      if (! $scope.pages[index]) {
        return false;
      }

      var url = '';
      if ($rootScope.allowScheme) {
        url = $scope.pages[index].app_page_link;
      } else {
        url = $scope.pages[index].page_link;
      }

      $rootScope.gotoLink(url);
    };

    $scope.init = function () {
      fCache.init(function () {
        var pages = [];
        if (fCache.getPages().length) {
          angular.forEach(fCache.getPages(), function (item) {

            if ($stateParams.categoryId && item.category_id !== $stateParams.categoryId) {
              return;
            }

            if (item.category_id) {
              item.category = fCache.findCategoryById(item.category_id);
            }

            pages.push(item);
          });
          $scope.pages = pages;
        }
      });
    };
    $scope.init();

  }]);

'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PageVoteCtrl
 * @description
 * # PageVoteCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PageVoteCtrl', ["$scope", "$rootScope", "$stateParams", "$http", "$window", "fCache", "shareParams", "appGlobal", function ($scope, $rootScope, $stateParams, $http, $window, fCache, shareParams, appGlobal) {
    var pages = [];
    $scope.page = {};
    $scope.categories = [];
    $scope.pageId = '';

    $scope.sendVote = function () {
      var categoryId = angular.element('#category_id').val();
      if (! $rootScope.uuid || ! $stateParams.fbId || ! categoryId) {
        return false;
      }

      $http.post(appGlobal.host + '/vote', {
        device_id: $rootScope.uuid,
        fb_id: $stateParams.fbId,
        category_id: categoryId
      }).
        success(function(data, status, headers, config) {
          if (data.status === 'success') {
            $window.alert('Đăng ký thành công!');
          }
          return;
        }).
        error(function(data, status, headers, config) {
          $window.alert(data.data);
          return;
        });
    };

    $scope.init = function () {
      $rootScope.showLoading('Đang tải.');

      $scope.pageId = $stateParams.pageId;

      fCache.init(function () {
        $rootScope.hideLoading();

        $scope.page = shareParams.getVote();
        pages = fCache.getPages();
        $scope.categories = fCache.getCategories();
      });

    };
    $scope.init();
  }]);

'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PageVoteSearchCtrl
 * @description
 * # PageVoteSearchCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PageVoteSearchCtrl', ["$scope", "$rootScope", "$http", "$location", "$cordovaKeyboard", "appGlobal", "shareParams", function ($scope, $rootScope, $http, $location, $cordovaKeyboard, appGlobal, shareParams) {
    $scope.pages = [];
    $scope._page = 0;
    $scope.last_request = '';
    $scope.loading = true;

    $scope.gotoVotePage = function (index) {
      if ($scope.pages[index]) {
        shareParams.setVote($scope.pages[index]);
      }

      $location.path('/page/vote/' + $scope.pages[index].id);
    };

    $scope.gotoPageLink = function (index) {
      var url = '';
      if ($scope.pages[index]) {
        if ($rootScope.allowScheme) {
          url = $scope.pages[index].app_page_link;
        } else {
          url = $scope.pages[index].page_link;
        }
      }
      $rootScope.gotoLink(url);
    };

    $scope.init = function () {
      $('#dln_search_page').on('change', function () {
        var searchVal = $(this).val();

        if (! searchVal) {
          return false;
        }

        // Hide keyboard
        if (window.cordova && window.cordova.plugins.Keyboard) {
          $cordovaKeyboard.close();
        }

        $rootScope.showLoading('Đang tải');

        var url = appGlobal.host + '/helper/search_vote?q=' + searchVal;
        $http.get(url)
          .success(function (resp) {
            $rootScope.hideLoading();
            $scope.loading = false;

            if (resp.status === 'success') {
              var pages = [];
              angular.forEach(resp.data, function (item) {
                pages.push(item);
              });
              $scope.pages = pages;
            }
          });
      });
    };
    $scope.init();
  }]);

'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:CategoryCtrl
 * @description
 * # CategoryCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('CategoryCtrl', ["$scope", "$location", "fCache", function ($scope, $location, fCache) {
    $scope.categories = [];

    $scope.gotoPages = function (index) {
      if (! index) {
        return;
      }

      $location.path('/category/' + $scope.categories[index].id);
    };

    $scope.init = function () {
      fCache.init(function () {
        $scope.categories = fCache.getCategories();
      });
    };

    $scope.init();

  }]);

'use strict';

/**
 * @ngdoc directive
 * @name fbFeedsApp.directive:scrollWatch
 * @description
 * # scrollWatch
 */
angular.module('fbFeedsApp')
  .directive('scrollWatch', ["$rootScope", function ($rootScope) {
    return function(scope, elem, attr) {
      var start = 0;
      var threshold = 150;
      var timeout = '';
      elem.bind('scroll', function(e) {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
          if(e.currentTarget.scrollTop - start > threshold) {
            $rootScope.slideHeader = true;
          } else {
            $rootScope.slideHeader = false;
          }
          if ($rootScope.slideHeaderPrevious >= e.currentTarget.scrollTop - start) {
            $rootScope.slideHeader = false;
          }
          $rootScope.slideHeaderPrevious = e.currentTarget.scrollTop - start;
          $rootScope.$apply();
        }, 75);
      });
    };
  }]);

'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('AboutCtrl', ["$scope", function ($scope) {
    $scope.email = 'admin@vivufb.com';
  }]);
