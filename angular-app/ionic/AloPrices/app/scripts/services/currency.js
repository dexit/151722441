'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.Currency
 * @description
 * # Currency
 * Factory in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .factory('Currency', function ($rootScope, $http, $translate, appGlobal) {
    var service = {};
    /**
     * Function to get currency listing
     *
     * @param string $types
     * @param callback $next
     * @return objects
     */
    service.getListCurrency = function ($types, $next) {
      var records = {};

      var url = appGlobal.host + '/currencies?types=' + $types

      // Show loading.
      $rootScope.showLoading();

      $http({
        url: url,
        method: 'GET'
      }).success(function (resp, status) {

        $next(resp.data);
      }).error(function (resp, status) {
        // Hide loading
        $rootScope.hideLoading();
        console.log(resp, status);
        alert(resp.data[0]);
      });
    };

    return service;
  });
