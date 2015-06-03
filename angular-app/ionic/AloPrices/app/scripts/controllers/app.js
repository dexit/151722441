'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:AppCtrl
 * @description
 * # AppCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('AppCtrl', function ($rootScope, $scope, $cordovaToast, $ionicLoading, $timeout) {

    // Set default disable overflow scrolling for ionic content.
    $rootScope.overflowScrolling = false;

    /**
     * Function to register device and get user_id
     *
     * @return void
     */
    $scope.registerDevice = function() { };

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
     * Initialize tabs
     *
     * @return void
     */
    $rootScope.initTabs = function () {
      // Toggle tabs.
      var tabSelector = '.tabs .tab-item';
      $(tabSelector).on('click', function (e) {
        e.preventDefault();

        $(tabSelector).removeClass('active');
        $(this).addClass('active');

        var target = $(this).data('target');
        if (target) {
          $('.exr-tab-content').removeClass('active');
          $('.exr-tab-content.exr-' + target).addClass('active');
        }
      });
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

    /**
     * Function for register GCM for current device.
     *
     * @return void
     */
    $scope.registerGCMAndroid = function () {
      var androidConfig = {
        'senderID': '265723301690'
      };

      $cordovaPush.register(androidConfig).then(function(result) {
        // Success
        console.log(result);
      }, function(err) {
        // Error
        console.log(err);
      });

      // Call back function on received notify
      $rootScope.$on('$cordovaPush:notificationReceived', function(event, notification) {
        switch(notification.event) {
          case 'registered':
            if (notification.regid.length > 0 ) {
              Device.getProfileId(notification.regid);
            }
            break;

          case 'message':
            // this is the actual push notification. its format depends on the data model from the push server
            alert('message = ' + notification.message + ' msgCount = ' + notification.msgcnt);
            break;

          case 'error':
            alert('GCM error = ' + notification.msg);
            break;

          default:
            alert('An unknown GCM event has occurred');
            break;
        }
      });
    };

    /**
     * Initialize function for App controller.
     *
     * @return void
     */
    $scope.initApp = function () {

      // Get profile id.
      $timeout(function() {
        $scope.registerGCMAndroid();
      }, 1000);

    };

  });
