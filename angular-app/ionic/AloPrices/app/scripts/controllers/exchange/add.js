'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangeAddCtrl
 * @description
 * # ExchangeAddCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangeAddCtrl', function ($scope, $routeParams, $state, Currency, appGlobal) {
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

      // Goto exchanges list.
      $state.go('app.exchanges');
    };

    /**
     * Initialize functions when view enter.
     *
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {

      // Get type from routeParams
      console.log($routeParams);
      type = ($routeParams.type) ? $routeParams.type : 'currency';

      // Get checked currencies.
      var checked = $scope.checkedCurrency;
      $scope.checkedCurrency = Currency.getSavedCheckedCurrency(checked);

      // Listing currencies
      Currency.getListCurrency(type, $scope.prepareItems);

    });

  });
