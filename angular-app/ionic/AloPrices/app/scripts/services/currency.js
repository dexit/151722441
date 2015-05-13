'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.Currency
 * @description
 * # Currency
 * Factory in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .factory('Currency', function ($rootScope, $http, $translate, appGlobal, localStorageService) {
    var service = {};

    /**
     * Function to get currency listing
     *
     * @param string types
     * @param callback $next
     * @return objects
     */
    service.getListCurrencyDetail = function (types, $next) {
      var url = appGlobal.host + '/currencies?types=' + types

      // Show loading.
      $rootScope.showLoading();

      $http({
        url: url,
        method: 'GET'
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        if (resp.data) {
          $next(resp.data);
        }

      }).error(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Show log
        console.log(resp, status);
        alert(resp.data[0]);

      });
    };

    /**
     * Send request for get listing currencies.
     *
     * @param string types
     * @param callback $next
     * @return void
     */
    service.getListCurrency = function (types, $next) {
      // Show loading
      $rootScope.showLoading();

      var url = appGlobal.host + '/currencies';
      $http({
        url: url,
        method: 'GET',
        params: {
          types: types
        }
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Fire next function
        if (resp.data) {
          $next(resp.data);
        }

      }).error(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Show log
        console.log(resp, status);
        alert(resp.data[0]);

      });

    };

    /**
     * Function for get currencies saved in local storage.
     *
     * @param string currencyIds
     * @param callback $next
     * @returns void
     */
    service.getSavedCurrencies = function (currencyIds, $next) {

      if (! currencyIds) {
        return false;
      }

      // Show loading
      $rootScope.showLoading();

      // Send request for listing
      url = appGlobal.uri + '/currencies/detail';

      $http({
        url: url,
        method: 'GET',
        params: {
          currency_ids: currencyIds
        }
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Save uid to storage.
        /*if (localStorageService.isSupported && resp.data) {
          localStorageService.set(appGlobal.exrSavedCurrencies, resp.data);
        }*/
        if (resp.data) {
          $next(resp.data);
        }

      }).error(function (data, status) {

        // Hide loading
        $rootScope.hideLoading();
        console.log(data);
        alert($translate('message.error_get_currency_detail'));

      });

    };

    /**
     * Function for get saved types from local storage.
     *
     * @returns array
     */
    service.getSavedTypes = function () {
      if (localStorageService.isSupported && localStorageService.get(appGlobal.exrSavedTypes)){
        return localStorageService.get(appGlobal.exrSavedTypes);
      }
    };

    /**
     * Function for save type to local storage.
     *
     * @param types
     * @returns {boolean}
     */
    service.saveTypes = function (types) {
      if (! types.length) {
        return false;
      }

      if (localStorageService.isSupported) {
        localStorageService.set(appGlobal.exrSavedTypes, types);
      }

      return true;
    };

    return service;
  });
