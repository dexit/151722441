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
     * @param string checkedIds
     * @param callback $next
     * @return objects
     */
    service.getListCurrencyDetail = function (checkedIds, $next) {
      var url = appGlobal.host + '/currencies/detail?currency_ids=' + checkedIds

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
     * Function for get checked currencies from local storage.
     *
     * @returns {*}
     */
    service.getSavedCheckedCurrency = function (checked) {
      if (localStorageService.isSupported && localStorageService.get(appGlobal.exrSavedCheckedCurrency)) {
        return localStorageService.get(appGlobal.exrSavedCheckedCurrency)
      } else {
        return checked;
      }
    };

    /**
     * Function for save checked currency ids to local storage.
     *
     * @param checkedIds
     * @return void
     */
    service.saveCheckedCurrency = function (checkedIds) {
      if (localStorageService.isSupported) {
        localStorageService.set(appGlobal.exrSavedCheckedCurrency, checkedIds);
      }
    };

    /**
     * Function for get detail currency.
     *
     * @param currencyId integer
     * @param $next callback
     * @return objects
     */
    service.getDetail = function (currencyId, $next) {
      currencyId = parseInt(currencyId);

      if (! currencyId) {
        return false;
      }

      // Show loading
      $rootScope.showLoading();

      var url = appGlobal.host + '/currency/' + currencyId;

      $http({
        url: url,
        method: 'GET',
        params: {}
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

    return service;
  });
