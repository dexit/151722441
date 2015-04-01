'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PageDetailCtrl
 * @description
 * # PageDetailCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PageCtrl', function ($scope, $http, $stateParams, $rootScope, localStorageService, fCache, sFeed) {
    $scope.page = null;
    $scope.category = null;
    $scope.feeds = [];
    $scope._page = 0;
    $scope.last_request = '';
    $scope.loading = true;

    /*$scope.getPage = function (id) {
      if (!id) {
        return false;
      }

      $rootScope.showLoading('Đang tải!');
      var url = appGlobal + '/pages/' + id;
      $http.get(url)
        .success(function (resp) {
          $scope.loading = false;

          if (resp.status === 'success') {
            $scope.page = resp.data;
          }
          $rootScope.hideLoading();
        })
        .error(function (data, status, headers, config) {
          $scope.loading = false;
          console.log(data, status, headers, config);
          window.alert('Không thể lấy tin, xin vui lòng thử lại!');
          $rootScope.hideLoading();
          if ($done) {
            $done();
          }
        });
    };*/

    $scope.scollGetFeeds = function () {
      sFeed.getFeeds($scope);
    };

    $scope.setFeeds = function (feeds) {
      $scope.feeds = feeds;
    };

    $scope.gotoFBLink = function (index) {
      if (! $scope.page[index]){
        return false;
      }

      var url = '';
      if ($rootScope.allowScheme) {
        url = $scope.page[index].app_page_link;
      } else {
        url = $scope.page[index].page_link;
      }

      $rootScope.gotoLink(url);
    };

    $scope.init = function () {
      if (! $stateParams.pageId) {
        $location.href = '/feeds';
      }

      localStorageService.set('dln_category_ids', null);

      fCache.init(function () {
        $scope.page = fCache.findPageById($stateParams.pageId);
        $scope.category = fCache.findCategoryById($scope.page.category_id);

        $scope.loading = false;
        $scope.page_id = $stateParams.pageId;
        sFeed.getFeeds($scope);
      });
    };
    $scope.init();

  });
