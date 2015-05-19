'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangesCtrl
 * @description
 * # ExchangesCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangesCtrl', function ($rootScope, $scope, Device, Currency) {
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
      var type         = $scope.type;
      if type ==''
      checked_= Currency.getSavedCheckedCurrency(checkedCurrency, 'currency');

      // Loading exchange rates
      Currency.getListCurrencyDetail(checkedCurrency.join(','), $scope.prepareItems);
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
        console.log("Error: " + err.message);
      }

      $scope.loadItems();
    });

  });
