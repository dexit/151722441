'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.Currency
 * @description
 * # Currency
 * Factory in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .factory('Currency', function ($http, $translate, appGlobal) {
    var service = {};

    /**
     * Function to get currency listing
     *
     * @return objects
     */
    service.getListCurrency = function () {
      var records = {};

      var url = appGlobal.host + '/currencies'
      $http({
        url: url,
        method: 'GET'
      }).success(function (data, status) {



      }).error(function (data, status) {
        console.log(data, status);
        alert();
      });
    };
  });
