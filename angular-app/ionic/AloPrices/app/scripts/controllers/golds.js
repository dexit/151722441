'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:GoldCtrl
 * @description
 * # GoldCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('GoldsCtrl', function ($rootScope, $scope, Device, Currency) {
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
  });
