'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:HomeCtrl
 * @description
 * # HomeCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('HomeCtrl', function ($rootScope, $scope) {
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

  });
