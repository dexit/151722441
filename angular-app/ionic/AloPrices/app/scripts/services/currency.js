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
      var url = appGlobal.host + '/currencies/detail?currency_ids=' + checkedIds;

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
        window.alert(resp.data[0]);

      });
    };

    /**
     * Send request for get listing currencies.
     *
     * @param string types
     * @param callback $next
     * @return void
     */
    service.getListCurrency = function (type, $next) {

      // Check data exists in caches
      var id = appGlobal.exrCachedListCurrency + '_' + type;
      if (localStorageService.isSupported && localStorageService.get(id)) {
        $next(localStorageService.get(id));
        return false;
      }

      // Show loading
      $rootScope.showLoading();

      var url = appGlobal.host + '/currencies';
      $http({
        url: url,
        method: 'GET',
        params: {
          type: type
        }
      }).success(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Fire next function
        if (resp.data) {

          if (localStorageService.isSupported) {
            localStorageService.set(id, resp.data);
          }

          $next(resp.data);
        }

      }).error(function (resp, status) {

        // Hide loading
        $rootScope.hideLoading();

        // Show log
        console.log(resp, status);
        window.alert(resp.data[0]);

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
      var url = appGlobal.uri + '/currencies/detail';

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
        window.alert($translate('message.error_get_currency_detail'));

      });

    };

    /**
     * Function for get checked currencies from local storage.
     *
     * @param string type
     * @param array checked
     * @returns {*}
     */
    service.getSavedCheckedCurrency = function (checked, type) {
      if (localStorageService.isSupported && localStorageService.get(appGlobal.exrSavedCheckedCurrency  + '_' + type)) {
        return localStorageService.get(appGlobal.exrSavedCheckedCurrency  + '_' + type);
      } else {
        return checked;
      }
    };

    /**
     * Function for save checked currency ids to local storage.
     *
     * @param array checkedIds
     * @param string type
     * @return void
     */
    service.saveCheckedCurrency = function (checkedIds, type) {
      if (localStorageService.isSupported) {
        localStorageService.set(appGlobal.exrSavedCheckedCurrency + '_' + type, checkedIds);
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
        window.alert(resp.data[0]);
      });

    };

    return service;
  });
