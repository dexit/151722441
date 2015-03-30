'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PageVoteCtrl
 * @description
 * # PageVoteCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PageVoteCtrl', function ($scope, $rootScope, $stateParams, fCache, shareParams) {
    var pages = [];
    $scope.page = {};
    $scope.categories = [];
    $scope.pageId = '';

    $scope.init = function () {
      $rootScope.showLoading('Đang tải.');

      $scope.pageId = $stateParams.pageId;

      fCache.init(function () {
        $rootScope.hideLoading();

        $scope.page = shareParams.getVote();
        pages = fCache.getPages();
        $scope.categories = fCache.getCategories();
      });

    };
    $scope.init();
  });
