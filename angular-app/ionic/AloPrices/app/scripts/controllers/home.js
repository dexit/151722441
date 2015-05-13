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
    $scope.types = ['VCB', 'GOLD'];

    // Create sample data for items
    $scope.items = [];

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

      var types = $scope.types;
      types = types.join(',');

      // Loading exchange rates
      Currency.getListCurrencyDetail(types, $scope.prepareItems);
    });

  });
