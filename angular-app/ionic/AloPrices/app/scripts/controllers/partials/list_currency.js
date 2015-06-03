'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:PartialsListCurrencyCtrl
 * @description
 * # PartialsListCurrencyCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('PartialsListCurrencyCtrl', function ($scope, $rootScope, Currency, Device) {

    var checked_currency = [1, 2, 3, 4, 5];
    var checked_gold     = [1, 2, 3, 4, 5];
    var checkedCurrency  = [];
    $scope.items         = [];

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
     * Function for load items.
     *
     * @return void
     */
    $scope.loadItems = function () {
      // Load checked currency ids.
      var type    = $rootScope.type;
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
     * Perform share currency to SNS.
     *
     * @param item
     * @return void
     */
    $scope.share = function (item) {
      $rootScope.showMessage('Share clicked!');
    };

    /**
     * Initialize when enter view.
     *
     * @param object e
     * @param array args
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {

      // Loading items from server.
      $scope.loadItems();

    });

  });
