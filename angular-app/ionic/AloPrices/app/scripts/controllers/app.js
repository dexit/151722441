'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:AppCtrl
 * @description
 * # AppCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('AppCtrl', function ($scope, Device) {

    /**
     * Function to register device and get user_id
     *
     * @return void
     */
    $scope.registerDevice = function() {

    };

    /**
     * Initialize function for controller
     *
     * @return void
     */
    $scope.init = function() {
      // Register device id when start
    };
    $scope.init();

  });
