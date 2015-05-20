'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangeDetailCtrl
 * @description
 * # ExchangeDetailCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangeDetailCtrl', function ($scope, $stateParams, $translate) {

    $scope.type = 'currency';
    /* Setting for chart */
    $scope.chart_options = {
      animation: false,
      responsive: true
    };
    $scope.chart_labels = [];
    $scope.chart_series = [];
    $scope.chart_data   = [];
    $scope.items        = [];

    /**
     * Show detail currency information when click chart point.
     *
     * @param points
     * @param e
     * @return void
     */
    $scope.showDetailCurrency = function (points, e) {
      console.log(points, e);
    };

    /**
     * Function for prepare items data for display in charts.
     *
     * @param items
     * @returns {boolean}
     */
    $scope.prepareItems = function (items) {
      if (! items.length) {
        return false;
      }

      $scope.chart_labels = [];
      $scope.chart_data = [];

      switch ($scope.type) {
        case 'currency':
          $scope.chart_series = [ $translate('exchange_detail.exchange_rates') ];

          angular.forEach(items, function (key, item) {
            $scope.pushChartData(item.created_at, item.price);
          });
          break;

        case gold:
        case 'bank':
          $scope.chart_series = [ $translate('exchange_detail.buy'), $translate('exchange_detail.sell') ];

          angular.forEach(items, function (key, item) {
            $scope.pushChartData(item.created_at, [item.buy, item.sell]);
          });
          break;
      }

      $scope.items = items;
    };

    /**
     * Common function for push data to charts.
     *
     * @param labels
     * @param data
     */
    $scope.pushChartData = function (labels, data) {
      $scope.chart_labels.push(labels);
      $scope.chart_data.push(data);
    };

    /**
     * Initialize function on view enter.
     *
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {

      var exchangeId = $stateParams.id;

      // Get currency detail
      Currency.getDetail(exchangeId, $scope.prepareItems);

      // Get list notifications data.
      Device.getListNotifications();

    });

  });
