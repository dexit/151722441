'use strict';

angular.module('aloPricesApp', [
  'ngAnimate',
  'ngCookies',
  'ngRoute',
  'ngSanitize',
  'ionic',
  'ngCordova',
  'pascalprecht.translate',
  'LocalStorageModule',
  'chart.js'
]).config(["$translateProvider", "$stateProvider", "$urlRouterProvider", "localStorageServiceProvider", function ($translateProvider, $stateProvider, $urlRouterProvider, localStorageServiceProvider) {

  // Setting for languages.
  $translateProvider.preferredLanguage('vi');

  // Setting for local-storage.
  localStorageServiceProvider.setPrefix('aloPricesApp');
  localStorageServiceProvider.setStorageType('sessionStorage');
  localStorageServiceProvider.setStorageCookie(3, '/');

  /* Defalt route */
  $urlRouterProvider.otherwise('/ty-gia');

  /* For routes */
  $stateProvider
    .state('app', {
      url: '/',
      abstract: true,
      templateUrl: 'views/app.html',
      controller: 'AppCtrl'
    })
    .state('app.exchanges', {
      url: 'ty-gia',
      views: {
        'app-content': {
          templateUrl: 'views/exchanges.html',
          controller: 'ExchangesCtrl'
        }
      }
    })
    .state('app.golds', {
      url: 'gia-vang',
      views: {
        'app-content': {
          templateUrl: 'views/golds.html',
          controller: 'GoldsCtrl'
        }
      }
    })
    .state('app.exchange_add', {
      url: 'them-ty-gia/:type',
      views: {
        'app-content': {
          templateUrl: 'views/exchange/exchange-add.html',
          controller: 'ExchangeAddCtrl'
        }
      }
    })
    .state('app.exchange_detail', {
      url: 'ty-gia/:id',
      views: {
        'app-content': {
          templateUrl: 'views/exchange/exchange-detail.html',
          controller: 'ExchangeDetailCtrl'
        }
      }
    })
    .state('app.notifications', {
      url: 'notifications',
      views: {
        'app-content': {
          templateUrl: 'views/notifications.html',
          controller: 'NotificationsCtrl'
        }
      }
    })
    .state('app.setting', {
      url: 'setting',
      views: {
        'app-content': {
          templateUrl: 'views/setting.html',
          controller: 'SettingCtrl'
        }
      }
    });

}]).run(["$ionicPlatform", "$cordovaDevice", "Device", function ($ionicPlatform, $cordovaDevice, Device) {

  /* On ionic read platform */
  $ionicPlatform.ready(function () {
    // Hide the accessory bar by default (remove this to show the accessory bar above the keyboard
    // for form inputs)
    if (window.cordova && window.cordova.plugins.Keyboard) {
      cordova.plugins.Keyboard.hideKeyboardAccessoryBar(true);
    }
    if (window.StatusBar) {
      StatusBar.styleDefault();
    }
  });

}]);

'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.appGlobal
 * @description
 * # appGlobal
 * Service in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .constant('appGlobal', {
    host: 'http://home.vivufb.com/api/v1',
    testUUID: 'this-is-web-device',
    exrUid: 'storage_uid',
    exrSavedTypes: 'exr_saved_types',
    exrSavedCurrencies: 'exr_saved_currencies',
    exrSavedCheckedCurrency: 'exr_saved_currencies_checked',
    exrCachedListCurrency: 'exr_cached_list_currency'
  });

'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.Device
 * @description
 * # Device
 * Factory in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .factory('Device', ["$rootScope", "$http", "$translate", "$cordovaDevice", "appGlobal", "localStorageService", function ($rootScope, $http, $translate, $cordovaDevice, appGlobal, localStorageService) {
    var service = {};

    /**
     * Return current user id.
     *
     * @returns integer
     */
    service.getUserId = function () {
      if (localStorageService.isSupported && localStorageService.get(appGlobal.exrUid)){
        return localStorageService.get(appGlobal.exrUid);
      }
    };

    /**
     * Function to register device and get uid.
     *
     * @return integer profileId
     */
    service.getProfileId = function () {
      var self = this;

      // Get device id
      var uuid = $cordovaDevice.getUUID();

      if (appGlobal.testUUID) {
        uuid = appGlobal.testUUID;
      }

      if (! uuid) {
        return false;
      }

      // Return user id if exists in local storage.
      if (self.getUserId()) {
        return self.getUserId();
      }

      var url = appGlobal.host + '/devices';

      // Show loading
      $rootScope.showLoading();

      // Send request for register device.
      $http({
        url: url,
        method: 'POST',
        params: {
          device_id: uuid
        }
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Save uid to storage.
        if (localStorageService.isSupported && resp.data.id) {
          localStorageService.set(appGlobal.exrUid, resp.data.id);
        }

      }).error(function (data, status) {
        // Hide loading
        $rootScope.hideLoading();
        console.log(data);
        window.alert($translate('message.error_get_device'));
      });
    };

    /**
     * Function to get notifications for current device
     *
     * @return objects
     */
    service.getListNotifications = function() {
      if (! localStorageService.isSupported || ! localStorageService.get(appGlobal.exrUid)) {
        return false;
      }

      var profileId = localStorageService.get(appGlobal.exrUid);

      var url = appGlobal.host + '/notifications';
    };

    /**
     * Function for save gcm registration id to db.
     *
     * @param string pid
     * @param string reg_id
     * @param callback $next
     * @return void
     */
    service.registerGCMRegId = function (pid, reg_id, $next) {
      if (!pid || ! reg_id) {
        return false;
      }

      var url = appGlobal.host + '/devices/' + pid + '/gcm';

      // Show loading
      $rootScope.showLoading();

      // Send request for update registration id.
      $http({
        url : url,
        method: 'POST',
        params: {
          pid: pid,
          reg_id: reg_id
        }
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        $next(resp.data);

      }).error(function (resp, status) {
        // Hide loading
        $rootScope.hideLoading();
        console.log(resp.data);
        window.alert($translate('message.error_get_device'));
      });
    };

    return service;
  }]);

'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangesCtrl
 * @description
 * # ExchangesCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangesCtrl', ["$rootScope", "$scope", "Device", "Currency", function ($rootScope, $scope, Device, Currency) {
    $scope.allowSwipe = true;
    $scope.items = [];
    $scope.type = 'currency';
    var checked_currency = [1, 2, 3, 4, 5];
    var checked_gold = [1, 2, 3, 4, 5];

    /**
     * Perform share currency to SNS.
     *
     * @param item
     * @return void
     */
    $scope.share = function (item) {
      $rootScope.showMessage('Share clicked!');
    };

    /**
     * Function prepare items for view.
     *
     * @param items
     * @return objects
     */
    $scope.prepareItems = function (items) {
      if (! items.length) {
        return false;
      }

      var codes = {};
      angular.forEach(items, function (item, key) {

        // Check exists code.
        if (! item.currency.type) {
          return false;
        }

        // Check code exists in array.
        var _type = item.currency.type;
        if (! codes[_type]) {
          codes[_type] = [];
        }

        // Assign to stdClass codes.
        codes[_type].push(item);

      });

      $scope.items = codes;
    };

    /**
     * Toggle type value
     *
     * @param type
     * @returns {boolean}
     */
    $scope.onClickType = function (type) {
      if (! type) {
        return false;
      }

      $scope.type = type;

      $scope.loadItems();
    };

    /**
     * Function for load items.
     *
     * @return void
     */
    $scope.loadItems = function () {
      // Load checked currency ids.
      var type    = $scope.type;
      var checked = '';
      if (type === 'currency') {
        checked = checked_currency;
      } else {
        checked = checked_gold;
      }
      checked = Currency.getSavedCheckedCurrency(checked, type);

      // Loading exchange rates
      Currency.getListCurrencyDetail(checked.join(','), $scope.prepareItems);
    };

    /**
     * Initialize events
     *
     * @return void
     */
    $scope.init = function () {

      // Toggle tabs.
      var tabSelector = '.tabs .tab-item';
      $(tabSelector).on('click', function (e) {
        e.preventDefault();

        $(tabSelector).removeClass('active');
        $(this).addClass('active');
      });

    };

    /**
     * Initialize when enter view.
     *
     * @param object e
     * @param array args
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {
      // Init events.
      $scope.init();

      // Get profile id.
      try {
        Device.getProfileId();
      } catch (err) {
        console.log('Error: ' + err.message);
      }

      $scope.loadItems();
    });

  }]);

'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:GoldCtrl
 * @description
 * # GoldCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('GoldsCtrl', ["$rootScope", "$scope", "Device", "Currency", function ($rootScope, $scope, Device, Currency) {
    $scope.allowSwipe = true;
    $scope.items = [];
    var checkedCurrency = [];

    /**
     * Perform share currency to SNS.
     *
     * @param item
     * @return void
     */
    $scope.share = function (item) {
      $rootScope.showMessage('Share clicked!');
    };

    /**
     * Function prepare items for view.
     *
     * @param items
     * @return objects
     */
    $scope.prepareItems = function (items) {
      $scope.items = items;
    };

    /**
     * Initialize when enter view.
     *
     * @param object e
     * @param array args
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {
      // Get profile id.
      try {
        Device.getProfileId();
      } catch (err) {
        console.log('Error: ' + err.message);
      }

      // Load checked currency ids.
      checkedCurrency = Currency.getSavedCheckedCurrency('gold', checkedCurrency);
      checkedCurrency = checkedCurrency.join(',');

      // Loading exchange rates
      Currency.getListCurrencyDetail(checkedCurrency, $scope.prepareItems);
    });
  }]);

'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:SettingCtrl
 * @description
 * # SettingCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('SettingCtrl', ["$scope", function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  }]);

'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:NotificationsCtrl
 * @description
 * # NotificationsCtrl
 * Controller of the AloPrices
 */
angular.module('aloPricesApp')
  .controller('NotificationsCtrl', ["$scope", function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  }]);

'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:AppCtrl
 * @description
 * # AppCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('AppCtrl', ["$rootScope", "$scope", "$cordovaToast", "$ionicLoading", "$translate", "Device", function ($rootScope, $scope, $cordovaToast, $ionicLoading, $translate, Device) {

    // Set default disable overflow scrolling for ionic content.
    $rootScope.overflowScrolling = false;

    /**
     * Function to register device and get user_id
     *
     * @return void
     */
    $scope.registerDevice = function() { };

    /**
     * Initialize function for controller
     *
     * @return void
     */
    $scope.init = function() {
      // Register device id when start
    };
    $scope.init();

    /**
     * Global function for show toast message
     *
     * @param message
     * @return void
     */
    $rootScope.showMessage = function (message) {
      if ($cordovaToast) {
        $cordovaToast.showLongBottom(message).then(function(success) {
          // success
        }, function (error) {
          // error
        });
      } else {
        window.alert(message);
      }
    };

    /**
     * Global function for show loading indicator.
     *
     * @return void
     */
    $rootScope.showLoading = function () {
      $ionicLoading.show({
        noBackdrop: false,
        animation: 'fade-in',
        template: '<p class="item-icon-left">{{ "common.loading" | translate }}<ion-spinner icon="lines"></ion-spinner></p>'
      });
    };

    /**
     * Global function for hide loading indicator.
     *
     * @return void
     */
    $rootScope.hideLoading = function () {
      $ionicLoading.hide();
    };

  }]);

'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.Currency
 * @description
 * # Currency
 * Factory in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .factory('Currency', ["$rootScope", "$http", "$translate", "appGlobal", "localStorageService", function ($rootScope, $http, $translate, appGlobal, localStorageService) {
    var service = {};

    /**
     * Function to get currency listing
     *
     * @param string checkedIds
     * @param callback $next
     * @return objects
     */
    service.getListCurrencyDetail = function (checkedIds, $next) {
      var url = appGlobal.host + '/currencies/detail?currency_ids=' + checkedIds;

      // Show loading.
      $rootScope.showLoading();

      $http({
        url: url,
        method: 'GET'
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        if (resp.data) {
          $next(resp.data);
        }

      }).error(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Show log
        console.log(resp, status);
        window.alert(resp.data[0]);

      });
    };

    /**
     * Send request for get listing currencies.
     *
     * @param string types
     * @param callback $next
     * @return void
     */
    service.getListCurrency = function (type, $next) {

      // Check data exists in caches
      var id = appGlobal.exrCachedListCurrency + '_' + type;
      if (localStorageService.isSupported && localStorageService.get(id)) {
        $next(localStorageService.get(id));
        return false;
      }

      // Show loading
      $rootScope.showLoading();

      var url = appGlobal.host + '/currencies';
      $http({
        url: url,
        method: 'GET',
        params: {
          type: type
        }
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Fire next function
        if (resp.data) {

          if (localStorageService.isSupported) {
            localStorageService.set(id, resp.data);
          }

          $next(resp.data);
        }

      }).error(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Show log
        console.log(resp, status);
        window.alert(resp.data[0]);

      });

    };

    /**
     * Function for get currencies saved in local storage.
     *
     * @param string currencyIds
     * @param callback $next
     * @returns void
     */
    service.getSavedCurrencies = function (currencyIds, $next) {

      if (! currencyIds) {
        return false;
      }

      // Show loading
      $rootScope.showLoading();

      // Send request for listing
      var url = appGlobal.uri + '/currencies/detail';

      $http({
        url: url,
        method: 'GET',
        params: {
          currency_ids: currencyIds
        }
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Save uid to storage.
        /*if (localStorageService.isSupported && resp.data) {
          localStorageService.set(appGlobal.exrSavedCurrencies, resp.data);
        }*/
        if (resp.data) {
          $next(resp.data);
        }

      }).error(function (data, status) {

        // Hide loading
        $rootScope.hideLoading();
        console.log(data);
        window.alert($translate('message.error_get_currency_detail'));

      });

    };

    /**
     * Function for get checked currencies from local storage.
     *
     * @param string type
     * @param array checked
     * @returns {*}
     */
    service.getSavedCheckedCurrency = function (checked, type) {
      if (localStorageService.isSupported && localStorageService.get(appGlobal.exrSavedCheckedCurrency  + '_' + type)) {
        return localStorageService.get(appGlobal.exrSavedCheckedCurrency  + '_' + type);
      } else {
        return checked;
      }
    };

    /**
     * Function for save checked currency ids to local storage.
     *
     * @param array checkedIds
     * @param string type
     * @return void
     */
    service.saveCheckedCurrency = function (checkedIds, type) {
      if (localStorageService.isSupported) {
        localStorageService.set(appGlobal.exrSavedCheckedCurrency + '_' + type, checkedIds);
      }
    };

    /**
     * Function for get detail currency.
     *
     * @param currencyId integer
     * @param $next callback
     * @return objects
     */
    service.getDetail = function (currencyId, $next) {
      currencyId = parseInt(currencyId);

      if (! currencyId) {
        return false;
      }

      // Show loading
      $rootScope.showLoading();

      var url = appGlobal.host + '/currency/' + currencyId;

      $http({
        url: url,
        method: 'GET',
        params: {}
      }).success(function (resp, status) {
        // Hide loading
        $rootScope.hideLoading();

        if (resp.data) {
          $next(resp.data);
        }
      }).error(function (resp, status) {
        // Hide loading
        $rootScope.hideLoading();

        // Show log
        console.log(resp, status);
        window.alert(resp.data[0]);
      });

    };

    return service;
  }]);

'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:SettingFacebookCtrl
 * @description
 * # SettingFacebookCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('SettingFacebookCtrl', ["$scope", function ($scope) {

  }]);

'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangeAddCtrl
 * @description
 * # ExchangeAddCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangeAddCtrl', ["$scope", "$routeParams", "Currency", "appGlobal", function ($scope, $routeParams, Currency, appGlobal) {
    $scope.items = [];
    $scope.query = '';
    $scope.checkedCurrency = [];
    var type = '';

    /**
     * Prepare items for view.
     *
     * @param objects items
     * @return void
     */
    $scope.prepareItems = function (items) {
      if (! items.length) {
        return false;
      }

      var codes = {};
      angular.forEach(items, function (item, key) {

        // Check exists code.
        if (! item.type) {
          return false;
        }

        // Check code exists in array.
        var _type = item.type;
        if (! codes[_type]) {
          codes[_type] = [];
        }

        // Assign to stdClass codes.
        codes[_type].push(item);

      });

      $scope.items = codes;
    };

    /**
     * Filter function for searching items.
     *
     * @param item
     * @returns {boolean}
     */
    $scope.filterForItems = function (item) {
      var query = $scope.query;
      if (query && (item.name.indexOf(query) >= 0 || item.code.indexOf(query) >= 0)) {
        return true;
      }

      return false;
    };

    /**
     * Save currency checked to local storage.
     *
     * @param integer cId
     * @return void
     */
    $scope.onCheckedCurrency = function (cId) {

      var checkedId = $scope.checkedCurrency.indexOf(cId);
      if (checkedId > -1) {
        $scope.checkedCurrency.splice(checkedId, 1);
      } else {
        $scope.checkedCurrency.push(cId);
      }
    };

    /**
     * Save currency to database;
     *
     * @return void
     */
    $scope.onClickSave = function () {
      // Save currency to local storage.
      Currency.saveCheckedCurrency($scope.checkedCurrency, type);
    };

    /**
     * Initialize functions when view enter.
     *
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {

      // Get type from routeParams
      type = ($routeParams.type) ? $routeParams.type : 'ty-gia';

      // Get checked currencies.
      var checked = $scope.checkedCurrency;
      $scope.checkedCurrency = Currency.getSavedCheckedCurrency(checked);

      // Listing currencies
      Currency.getListCurrency(type, $scope.prepareItems);

    });

  }]);

'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangeDetailCtrl
 * @description
 * # ExchangeDetailCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangeDetailCtrl', ["$scope", "$stateParams", "$translate", "Currency", "Device", function ($scope, $stateParams, $translate, Currency, Device) {

    /* Setting for chart */
    $scope.chart_options = {
      animation: false,
      responsive: true
    };
    $scope.chart_labels = [];
    $scope.chart_series = ['Series A'];
    $scope.chart_data   = [];
    $scope.items        = [];

    /**
     * Show detail currency information when click chart point.
     *
     * @param points
     * @param e
     * @return void
     */
    $scope.showDetailCurrency = function (points, e) {
      console.log(points, e);
    };

    /**
     * Function for prepare items data for display in charts.
     *
     * @param items
     * @returns {boolean}
     */
    $scope.prepareItems = function (items) {
      if (! items.length) {
        return false;
      }

      $scope.chart_labels = [];

      switch (items[0].type) {
        case 'currency':
          $scope.chart_series = [ $translate('exchange_detail.exchange_rates') ];

          var arrData = [];
          angular.forEach(items, function (item, key) {
            $scope.pushChartData(item.created_at);
            arrData.push(item.buy);
          });

          $scope.chart_data.push(arrData);
          break;

        case 'gold':
        case 'bank':
          $scope.chart_series = [ $translate('exchange_detail.buy'), $translate('exchange_detail.sell') ];

          arrData = [];
          angular.forEach(items, function (key, item) {
            $scope.pushChartData(item.created_at);

            arrData.push([item.buy, item.sell]);
          });

          $scope.chart_data.push(arrData);
          break;
      }

      $scope.items = items;
    };

    /**
     * Common function for push data to charts.
     *
     * @param labels
     * @return void
     */
    $scope.pushChartData = function (labels) {
      $scope.chart_labels.push(labels);
    };

    /**
     * Initialize function on view enter.
     *
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {

      var exchangeId = $stateParams.id;

      // Get currency detail
      Currency.getDetail(exchangeId, $scope.prepareItems);

      // Get list notifications data.
      Device.getListNotifications();

    });

  }]);
