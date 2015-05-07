'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.Device
 * @description
 * # Device
 * Factory in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .factory('Device', function ($http, $translate, $cordovaDevice, appGlobal, localStorageService) {
    var service = {};
    var deviceId = '';

    /**
     * Function to get device_id.
     *
     * @return string deviceId
     */
    service.getDeviceId = function () {
      return $cordovaDevice.getUUID();
    };

    /**
     * Function to register device and get uid.
     *
     * @return integer uid
     */
    service.registerDevice = function () {
      var self = this;

      var url = appGlobal.host + '/devices';
console.log(self.getDeviceId());
      $http({
        url: url,
        method: 'POST',
        params: {
          device_id: self.getDeviceId()
        }
      }).success(function (data, status) {

        // Save uid to storage.
        if (localStorageService.isSupported && data.id) {
          localStorageService.set(appGlobal.exrUid, data.id);
        }
        console.log(localStorageService.get(appGlobal.exrUid));

      }).error(function (data, status) {
        console.log(data);
        console.log($translate('message.error_get_device'));
        alert($translate('message.error_get_device'))
      });
    };

    return service;
  });
