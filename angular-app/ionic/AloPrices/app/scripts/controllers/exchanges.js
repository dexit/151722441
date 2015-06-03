'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangesCtrl
 * @description
 * # ExchangesCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangesCtrl', function ($rootScope, $scope, $cordovaPush, $timeout, Device) {

    $scope.allowSwipe = true;
    $rootScope.type   = 'currency';

    /**
     * Initialize when enter view.
     *
     * @param object e
     * @param array args
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {
      // Init events.
      //$scope.init();
    });

  });
