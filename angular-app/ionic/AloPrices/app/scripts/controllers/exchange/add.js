'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangeAddCtrl
 * @description
 * # ExchangeAddCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangeAddCtrl', function ($scope, Currency, appGlobal) {

    $scope.items = [];
    $scope.query = '';
    $scope.checkedCurrency = [];
    var types = 'CURRENCY,VCB';

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
        var type = item.type;
        if (! codes[type]) {
          codes[type] = [];
        }

        // Assign to stdClass codes.
        codes[type].push(item);

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
     * Toggle type value
     *
     * @param type
     * @returns {boolean}
     */
    $scope.onClickType = function (type) {
      if (! type) {
        return false;
      }

      // Listing currencies
      Currency.getListCurrency(type, $scope.prepareItems);
    };

    /**
     * Save currency checked to local storage.
     *
     * @return void
     */
    $scope.onClickSaveCurrency = function () {
      var checkedIds = $scope.checkedCurrency;

      // Save currency to local storage.
      Currency.saveCheckedCurrency(checkedIds);
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
     * Initialize functions when view enter.
     *
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {

      // Init events.
      $scope.init();

      // Get checked currencies.
      var checked = $scope.checkedCurrency;
      $scope.checkedCurrency = Currency.getSavedCheckedCurrency(checked);

      // Listing currencies
      Currency.getListCurrency(types, $scope.prepareItems);

    });

  });
