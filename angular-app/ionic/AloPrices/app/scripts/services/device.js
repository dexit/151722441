'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.Device
 * @description
 * # Device
 * Factory in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .factory('Device', function ($rootScope, $http, $filter, $cordovaDevice, $sessionStorage, $localStorage, appGlobal) {
    var service = {};

    /**
     * Return current user id.
     *
     * @return integer
     */
    service.getUserId = function () {
      if ($localStorage[appGlobal.exrUid]) {
        return $localStorage[appGlobal.exrUid];
      }
    };

    /**
     * Return device id.
     *
     * @return string
     */
    service.getDeviceId = function () {
      var uuid = $cordovaDevice.getUUID();

      if (! uuid && appGlobal.testUUID) {
        uuid = appGlobal.testUUID;
      }

      return uuid;
    };

    /**
     * Function to register device and get uid.
     *
     * @return integer profileId
     */
    service.getProfileId = function (gcmRegId) {
      var self = this;

      // Get device id
      var uuid = this.getDeviceId();

      if (! uuid) {
        return false;
      }

      // Return user id if exists in local storage.
      if (self.getUserId()) {
        return self.getUserId();
      }

      var url = appGlobal.host + '/devices';

      // Send request for register device.
      $http({
        url: url,
        method: 'POST',
        data: {
          device_id: uuid,
          gcm_reg_id: gcmRegId
        }
      }).success(function (resp, status) {

        // Save uid to storage.bower
        if (resp.data.id) {
          $localStorage[appGlobal.exrUid] = resp.data.id;
        }

      }).error(function (data, status) {
        console.log(data);
        window.alert($filter('translate')('message.error_get_device'));
      });
    };

    /**
     * Function for save gcm registration id to db.
     *
     * @param string pid
     * @param string reg_id
     * @param callback $next
     * @return void
     */
    service.registerGCMRegId = function (reg_id, $next) {
      if (! reg_id) {
        return false;
      }

      var url = appGlobal.host + '/devices';

      // Show loading
      $rootScope.showLoading();

      // Send request for update registration id.
      $http({
        url : url,
        method: 'POST',
        data: {
          device_id: pid,
          reg_id: reg_id
        }
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        $next(resp.data);

      }).error(function (resp, status) {
        // Hide loading
        $rootScope.hideLoading();
        console.log(resp.data);
        window.alert($filter('translate')('message.error_get_device'));
      });
    };

    /**
     * Get notification saved by device id.
     *
     * @param integer device_id
     * @param callback $next
     * @returns {boolean}
     */
    service.getCheckedNotify = function (device_id, $next) {
      if (! parseInt(device_id)) {
        return false;
      }

      var url = appGlobal.host + '/notifications';

      // Show loading
      $rootScope.showLoading();

      // Send request for get notifications.
      $http({
        url: url,
        method: 'GET',
        params: {
          device_id: device_id
        }
      }).success(function (resp, status) {

        if (resp.data) {
          $next(resp.data);
        }

      }).error(function (resp, status) {
        // Hide loading
        $rootScope.hideLoading();
        console.log(resp.data);
        window.alert($filter('translate')('message.error_get_device_notify'));
      });
    };

    return service;
  });
