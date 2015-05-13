'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:AppCtrl
 * @description
 * # AppCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('AppCtrl', function ($rootScope, $scope, $cordovaToast, $ionicLoading, $translate, Device) {

    // Set default disable overflow scrolling for ionic content.
    $rootScope.overflowScrolling = false;

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

    /**
     * Global function for show toast message
     *
     * @param message
     * @return void
     */
    $rootScope.showMessage = function (message) {
      if ($cordovaToast) {
        $cordovaToast.showLongBottom(message).then(function(success) {
          // success
        }, function (error) {
          // error
        });
      } else {
        alert(message);
      }
    };

    /**
     * Global function for show loading indicator.
     *
     * @return void
     */
    $rootScope.showLoading = function () {
      $ionicLoading.show({
        noBackdrop: false,
        animation: 'fade-in',
        template: '<p class="item-icon-left">{{ "common.loading" | translate }}<ion-spinner icon="lines"></ion-spinner></p>'
      });
    };

    /**
     * Global function for hide loading indicator.
     *
     * @return void
     */
    $rootScope.hideLoading = function () {
      $ionicLoading.hide();
    };

  });
