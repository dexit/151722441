'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PageVoteCtrl
 * @description
 * # PageVoteCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PageVoteCtrl', function ($scope, $rootScope, $stateParams, $http, fCache, shareParams, appGlobal) {
    var pages = [];
    $scope.page = {};
    $scope.categories = [];
    $scope.pageId = '';

    $scope.sendVote = function () {
      var categoryId = angular.element('#category_id').val();
      if (! $rootScope.uuid || ! $stateParams.fbId || ! categoryId) {
        return false;
      }

      $http.post(appGlobal.host + '/vote', {
        device_id: $rootScope.uuid,
        fb_id: $stateParams.fbId,
        category_id: categoryId
      }).
        success(function(data, status, headers, config) {
          if (data.status == 'success') {
            alert('Đăng ký thành công!');
          }
        }).
        error(function(data, status, headers, config) {
          alert(data.data);
        });
    };

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
