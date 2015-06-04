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
      tooltipTemplate: '<%= window.formatNumber(value) %>'
    };
    $scope.chart_colours = ['#33cd5f', '#ef473a'];
    $scope.chart_labels = [];
    $scope.chart_series = ['Series A'];
    $scope.chart_data   = [];
    $scope.items        = [];
    $scope.notifications = [
      {name: $filter('translate')('exchange_detail.buy_min'), slug: 'currency_min'},
      {name: $filter('translate')('exchange_detail.buy_max'), slug: 'currency_max'}
    ];
    var allow_ntfs_types = [
      'currency_min', 'currency_max'
    ];
    $scope.checked_notifies = null;
    var exchangeId = 0;

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

      // Save to sessions.
      var paramId = eval($sessionStorage.currency_ + exchangeId);
      paramId = items;
    };

    /**
     * Function for prepare checked notifies.
     *
     * @param checked_notifies
     * @return void
     */
    $scope.prepareCheckedNotifies = function (checked_notifies) {
      $scope.checked_notifies = checked_notifies;
    };

    /**
     * Common function for push data to charts.
     *
     * @param labels
     * @return void
     */
    $scope.pushChartData = function (labels) {
      var dateBefore = moment(labels).format('DD/MM');
      $scope.chart_labels.push(dateBefore);
    };

    /**
     * Function on toggle notification.
     *
     * @param notify_type
     * @return void
     */
    $scope.onToggleNotification = function (notify_type) {
      if (allow_ntfs_types.indexOf(notify_type) < 0) {
        return false;
      }

      var currency_id = $stateParams.id;
      var device_id   = Device.getDeviceId();

      // Check input params.
      if (! currency_id || ! device_id || ! notify_type) {
        return false;
      }

      // Send request for update notify.
      var url = appGlobal.host + '/notifications';

      $http({
        url: url,
        method: 'POST',
        data: {
          device_id: device_id,
          currency_id: currency_id,
          notify_type: notify_type
        }
      }).success(function (resp, status) {

      }).error(function (data, status) {
        console.log(data);
        window.alert($filter('translate')('message.error_register_notify'));
      });
    };

    /**
     * Initialize function on view enter.
     *
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {

      exchangeId = $stateParams.id;

      // Get currency detail
      Currency.getDetail(exchangeId, $scope.prepareItems);

      // Get list notifications data.
      Device.getCheckedNotify();

      //$scope.ntfsSelections = Notification.getSavedNotifications();

      // Init tabs
      //$rootScope.initTabs();
    });

  });
