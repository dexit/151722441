'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangeDetailCtrl
 * @description
 * # ExchangeDetailCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangeDetailCtrl', function ($rootScope, $scope, $stateParams, $filter, Currency, Device) {

    /* Setting for chart */
    $scope.chart_options = {
      animation: false,
      responsive: true,
      colours: {
        pointColor: '#33cd5f'
      },
      tooltipTemplate: '<%= window.formatNumber(value) %>'
    };
    $scope.chart_labels = [];
    $scope.chart_series = ['Series A'];
    $scope.chart_data   = [];
    $scope.items        = [];
    $scope.notifications = [
      {name: $filter('translate')('exchange_detail.buy_min'), slug: 'currency_min'},
      {name: $filter('translate')('exchange_detail.buy_max'), slug: 'currency_max'}
    ];

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

      switch (items[0].type) {
        case 'currency':
          $scope.chart_series = [ $filter('translate')('exchange_detail.exchange_rates') ];

          var arrData = [];
          angular.forEach(items, function (item, key) {
            $scope.pushChartData(item.created_at);
            arrData.push(parseInt(item.buy));
          });

          $scope.chart_data.push(arrData);
          break;

        case 'gold':
          $scope.chart_series = [ $filter('translate')('exchange_detail.buy'), $filter('translate')('exchange_detail.sell') ];

          arrData = [];
          angular.forEach(items, function (item, key) {
            $scope.pushChartData(item.created_at);

            arrData.push([parseInt(item.buy * 1000000), parseInt(item.sell * 1000000)]);
          });

          $scope.chart_data.push(arrData);
          break;

        case 'bank':
          $scope.chart_series = [ $filter('translate')('exchange_detail.buy'), $filter('translate')('exchange_detail.sell') ];

          arrData = [];
          angular.forEach(items, function (item, key) {
            $scope.pushChartData(item.created_at);

            arrData.push([item.buy, item.sell]);
          });

          $scope.chart_data.push(arrData);
          break;
      }

      $scope.items = items;
    };

    /**
     * Common function for push data to charts.
     *
     * @param labels
     * @return void
     */
    $scope.pushChartData = function (labels) {
      var dateBefore = moment(labels).format('DD-MM');
      $scope.chart_labels.push(dateBefore);
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

      //$scope.ntfsSelections = Notification.getSavedNotifications();

      $rootScope.initTabs();
    });

  });
