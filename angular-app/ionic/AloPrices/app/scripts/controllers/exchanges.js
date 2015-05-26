'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangesCtrl
 * @description
 * # ExchangesCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangesCtrl', function ($rootScope, $scope, $cordovaPush, $timeout, Device, Currency) {
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

    $scope.registerGCMAndroid = function () {
      var androidConfig = {
        'senderID': '265723301690'
      };

      $cordovaPush.register(androidConfig).then(function(result) {
        // Success
        console.log(result);
      }, function(err) {
        // Error
        console.log(err);
      });

      $rootScope.$on('$cordovaPush:notificationReceived', function(event, notification) {
        switch(notification.event) {
          case 'registered':
            if (notification.regid.length > 0 ) {
              Device.getProfileId(notification.regid);
            }
            break;

          case 'message':
            // this is the actual push notification. its format depends on the data model from the push server
            alert('message = ' + notification.message + ' msgCount = ' + notification.msgcnt);
            break;

          case 'error':
            alert('GCM error = ' + notification.msg);
            break;

          default:
            alert('An unknown GCM event has occurred');
            break;
        }
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
      $timeout(function() {
        //$scope.registerGCMAndroid();
      }, 1000);

      $scope.loadItems();
    });

  });
