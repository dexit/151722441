'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangeExchangeaddCtrl
 * @description
 * # ExchangeExchangeaddCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangeExchangeaddCtrl', function ($scope, Currency, appGlobal) {

    $scope.items = [];
    $scope.types = ['CURRENCY', 'GOLD'];

    /**
     * Prepare items for view.
     *
     * @param objects items
     * @return void
     */
    $scope.prepareItems = function (items) {
      $scope.items = items;
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

      if ($scope.types.indexOf(type)) {
        $scope.types.splice(type, 1);
      } else {
        $scope.types.push(type);
      }

      var types = $scope.types;

      // Save type to local storage
      Currency.saveTypes(types);
    };

    /**
     * Initialize functions when view enter.
     *
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {

      // Get types
      var types = $scope.types;

      // Check types saved in cache
      types = (Currency.getSavedTypes().length) ? Currency.getSavedTypes() : types;

      // Listing currencies
      Currency.getListCurrency(types, $scope.prepareItems);

    });

  });
