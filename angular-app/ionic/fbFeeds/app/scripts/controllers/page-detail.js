'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PageDetailCtrl
 * @description
 * # PageDetailCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PageDetailCtrl', function ($scope, $http, $stateParams, $rootScope, appGlobal, shareParams, fCache, localStorageService) {
    $scope.page = null;
    $scope.category = null;
    var dln_page_id = 'dln_page_id';

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

    $scope.gotoPageLink = function (index) {
      if (! $scope.page[index]){
        return false;
      }

      var url = '';
      if ($rootScope.allowScheme) {
        url = $scope.page[index].app_page_link;
      } else {
        url = $scope.page[index].page_link;
      }

      window.open(url, '_system', 'location=yes,toolbar=yes');
    };

    $scope.$on('$ionicView.enter', function (e, args) {
      fCache.init(function () {
        $scope.page = fCache.findPageById($stateParams.pageId);
        $scope.category = fCache.findCategoryById($scope.page.id);

        if (localStorageService.isSupported) {
          localStorageService.set(dln_page_id, $stateParams.pageId);
        }

        $rootScope.$emit('onRequestFeeds', null);
      });
    });

  });
