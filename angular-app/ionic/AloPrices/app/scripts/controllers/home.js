'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:HomeCtrl
 * @description
 * # HomeCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('HomeCtrl', function ($rootScope, $scope, Device) {
    $scope.allowSwipe = true;

    // Create sample data for items
    $scope.items = [
      {id: 1, name: 'Test 1', price: 125, suffix: '(+12)'},
      {id: 1, name: 'Test 1', price: 125, suffix: '(+12)'},
      {id: 1, name: 'Test 1', price: 125, suffix: '(+12)'},
      {id: 1, name: 'Test 1', price: 125, suffix: '(+12)'},
      {id: 1, name: 'Test 1', price: 125, suffix: '(+12)'},
      {id: 1, name: 'Test 1', price: 125, suffix: '(+12)'},
      {id: 1, name: 'Test 1', price: 125, suffix: '(+12)'},
      {id: 1, name: 'Test 1', price: 125, suffix: '(+12)'},
    ];

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
      console.log(e, args);

      // Get profile id.
      Device.getProfileId();

      var types = 'CURRENCY,GOLD';
      // Loading exchange rates
      Currency.getListCurrencyDetail(types, $scope.prepareItems);

    });

  });
