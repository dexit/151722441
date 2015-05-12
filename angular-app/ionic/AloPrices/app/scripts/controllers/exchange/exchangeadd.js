'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangeExchangeaddCtrl
 * @description
 * # ExchangeExchangeaddCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangeExchangeaddCtrl', function ($scope, Currency, appGlobal) {

    $scope.listCurrencies = [];
    $scope.listGolds      = [];

    $scope.init = function () {
      console.log(appGlobal);
      // Get currencies listing.
      Currency.getListCurrency('CURRENCY,VCB', function (data) {

      });
    };
    $scope.init();

  });
