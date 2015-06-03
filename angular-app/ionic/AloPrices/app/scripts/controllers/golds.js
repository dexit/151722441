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
    $rootScope.type   = 'gold';

  });
