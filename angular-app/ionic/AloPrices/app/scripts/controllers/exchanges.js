'use strict';

/**
 * @ngdoc function
 * @name aloPricesApp.controller:ExchangesCtrl
 * @description
 * # ExchangesCtrl
 * Controller of the aloPricesApp
 */
angular.module('aloPricesApp')
  .controller('ExchangesCtrl', function ($rootScope, $scope, Device, Currency) {
    $scope.allowSwipe = true;
    $scope.items = [];
    var checkedCurrency = [];

    /**
     * Perform share currency to SNS.
     *
     * @param item
     * @return void
     */
    $scope.share = function (item) {
      $rootScope.showMessage('Share clicked!');
    };

    /**
     * Function prepare items for view.
     *
     * @param items
     * @return objects
     */
    $scope.prepareItems = function (items) {
      $scope.items = items;
    };

    /**
     * Toggle type value
     *
     * @param type
     * @returns {boolean}
     */
    $scope.onClickType = function (type) {
      if (! type) {
        return false;
      }

      // Listing currencies
      //Currency.getListCurrency(type, $scope.prepareItems);

    };

    /**
     * Initialize events
     *
     * @return void
     */
    $scope.init = function () {

      // Toggle tabs.
      var tabSelector = '.tabs .tab-item';
      $(tabSelector).on('click', function (e) {
        e.preventDefault();

        $(tabSelector).removeClass('active');
        $(this).addClass('active');
      });

    };

    /**
     * Initialize when enter view.
     *
     * @param object e
     * @param array args
     * @return void
     */
    $scope.$on('$ionicView.enter', function (e, args) {
      // Init events.
      $scope.init();

      // Get profile id.
      try {
        Device.getProfileId();
      } catch (err) {
        console.log("Error: " + err.message);
      }

      // Load checked currency ids.
      checkedCurrency = Currency.getSavedCheckedCurrency('currency', checkedCurrency);
      checkedCurrency = checkedCurrency.join(',');

      // Loading exchange rates
      Currency.getListCurrencyDetail(checkedCurrency, $scope.prepareItems);
    });

  });
