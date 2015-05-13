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
    $scope.type  = ['CURRENCY'];

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

      $scope.type = type;
      var types = $scope.type;
      // Save type to local storage
      Currency.saveTypes(types);

      // Listing currencies
      Currency.getListCurrency(types, $scope.prepareItems);
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

      // Get types
      var types = $scope.types;

      // Check types saved in cache
      types = (Currency.getSavedTypes()) ? Currency.getSavedTypes() : types;

      // Listing currencies
      Currency.getListCurrency(types, $scope.prepareItems);

    });

  });
