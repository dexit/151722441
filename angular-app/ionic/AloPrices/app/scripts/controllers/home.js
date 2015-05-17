'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:HomeCtrl
 * @description
 * # HomeCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('HomeCtrl', function ($rootScope, $scope, Device, Currency) {
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
        console.log("Error: " + err.message);
      }

      // Load checked currency ids.
      checkedCurrency = Currency.getSavedCheckedCurrency(checkedCurrency);
      checkedCurrency = checkedCurrency.join(',');
      console.log(checkedCurrency);

      // Loading exchange rates
      Currency.getListCurrencyDetail(checkedCurrency, $scope.prepareItems);
    });

  });
