'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.Device
 * @description
 * # Device
 * Factory in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .factory('Device', function ($rootScope, $http, $translate, $cordovaDevice, appGlobal, localStorageService) {
    var service = {};

    /**
     * Return current user id.
     *
     * @returns integer
     */
    service.getUserId = function () {
      if (localStorageService.isSupported && localStorageService.get(appGlobal.exrUid)){
        return localStorageService.get(appGlobal.exrUid);
      }
    };

    /**
     * Function to register device and get uid.
     *
     * @return integer profileId
     */
    service.getProfileId = function () {
      var self = this;

      // Get device id
      var uuid = $cordovaDevice.getUUID();

      if (appGlobal.testUUID) {
        uuid = appGlobal.testUUID;
      }

      if (! uuid) {
        return false;
      }

      // Return user id if exists in local storage.
      if (self.getUserId()) {
        return self.getUserId();
      }

      var url = appGlobal.host + '/devices';

      // Show loading
      $rootScope.showLoading();

      // Send request for register device.
      $http({
        url: url,
        method: 'POST',
        params: {
          device_id: uuid
        }
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Save uid to storage.
        if (localStorageService.isSupported && resp.data.id) {
          localStorageService.set(appGlobal.exrUid, resp.data.id);
        }

      }).error(function (data, status) {
        // Hide loading
        $rootScope.hideLoading();
        console.log(data);
        window.alert($translate('message.error_get_device'));
      });
    };

    /**
     * Function to get notifications for current device
     *
     * @return objects
     */
    service.getListNotifications = function() {
      if (! localStorageService.isSupported || ! localStorageService.get(appGlobal.exrUid)) {
        return false;
      }

      var profileId = localStorageService.get(appGlobal.exrUid);

      var url = appGlobal.host + '/notifications';
    };

    /**
     * Function for save gcm registration id to db.
     *
     * @param string pid
     * @param string reg_id
     * @param callback $next
     * @return void
     */
    service.registerGCMRegId = function (pid, reg_id, $next) {
      if (!pid || ! reg_id) {
        return false;
      }

      var url = appGlobal.host + '/devices/' + pid + '/gcm';

      // Show loading
      $rootScope.showLoading();

      // Send request for update registration id.
      $http({
        url : url,
        method: 'POST',
        params: {
          pid: pid,
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
        window.alert($translate('message.error_get_device'));
      });
    };

    return service;
  });
