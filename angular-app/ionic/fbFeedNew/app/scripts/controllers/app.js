'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:AppCtrl
 * @description
 * # AppCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('AppCtrl', function ($scope, $rootScope) {

    $scope.init = function () {
      $rootScope.feedType = 'new';

      $('#dln_tab_feed .tab-item').on('click', function (e) {
        e.preventDefault();

        $('#dln_tab_feed .tab-item.active').removeClass('active');
        $(this).addClass('active');
        $rootScope.feedType = $(this).data('type');
        $rootScope.$emit('onFeedRefreshFeeds', null);
      });
    };
    $scope.init();

  });
