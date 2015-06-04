'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangeDetailListCtrl
 * @description
 * # ExchangeDetailListCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangeDetailListCtrl', function ($scope) {

    $scope.items = [];

    $scope.onShare = function (item) {
      window.plugins.socialsharing.share('Message and link', 'message subject', null, 'http://www.x-services.nl');
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

            arrData.push(item.buy);
          });

          $scope.chart_data.push(arrData);
          break;

        case 'gold':
          $scope.chart_series = [ $filter('translate')('exchange_detail.buy'), $filter('translate')('exchange_detail.sell') ];

          var arrBuy  = [];
          var arrSell = [];
          angular.forEach(items, function (item, key) {
            $scope.pushChartData(item.created_at);

            arrBuy.push(item.buy);
            arrSell.push(item.sell);
          });

          $scope.chart_data.push(arrBuy);
          $scope.chart_data.push(arrSell);
          break;

        case 'bank':
          $scope.chart_series = [ $filter('translate')('exchange_detail.buy'), $filter('translate')('exchange_detail.sell') ];

          var arrBuy  = [];
          var arrSell = [];
          angular.forEach(items, function (item, key) {
            $scope.pushChartData(item.created_at);

            arrBuy.push(item.buy);
            arrSell.push(item.sell);
          });

          $scope.chart_data.push(arrBuy);
          $scope.chart_data.push(arrSell);
          break;
      }

      $scope.items = items;
    };

    /**
     * Initialize function on view enter.
     *
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {

      var exchangeId = $stateParams.id;

      var paramId = eval($sessionStorage.currency_ + exchangeId);
      console.log(paramId, eval(paramId));
      if (paramId) {
        // Get currency detail
        Currency.getDetail(exchangeId, $scope.prepareItems);
      }

      $cordovaSocialSharing
        .share(message, subject, file, link) // Share via native share sheet
        .then(function(result) {
          alert('Share completed!');
        }, function(err) {
          alert('Share error!');
          // An error occured. Show a message to the user
        });

    });

  });
