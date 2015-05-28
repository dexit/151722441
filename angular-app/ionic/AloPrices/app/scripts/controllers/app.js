'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:AppCtrl
 * @description
 * # AppCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('AppCtrl', function ($rootScope, $scope, $cordovaToast, $ionicLoading, Device) {

    // Set default disable overflow scrolling for ionic content.
    $rootScope.overflowScrolling = false;

    /**
     * Function to register device and get user_id
     *
     * @return void
     */
    $scope.registerDevice = function() { };

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
        window.alert(message);
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

    /**
     * Global function for format number.
     *
     * @param integer num
     * @returns {*}
     */
    window.formatNumber = function (num) {
      var returnNumber = '';
      if (angular.isArray(num)) {
        angular.forEach(num, function (value, key) {
          returnNumber += value.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + ' VNĐ ';
        });
      } else {
        returnNumber = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") + ' VNĐ'
      }
      return returnNumber;
    };

  });
