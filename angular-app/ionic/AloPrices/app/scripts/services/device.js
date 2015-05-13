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
          localStorageService.set(appGlobal.exrUid, data.id);
        }

      }).error(function (data, status) {

        // Hide loading
        $rootScope.hideLoading();
        console.log(data);
        alert($translate('message.error_get_device'))

      });
    };

    return service;
  });
