'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PageDetailCtrl
 * @description
 * # PageDetailCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PageDetailCtrl', function ($scope, $http, $stateParams, $rootScope, appGlobal, shareParams) {
    $scope.page = null;
    $scope.category = null;

    $scope.$on('$ionicView.enter', function (e, args) {
      $scope.page = shareParams.getPage();
      if (!$scope.page) {
        $scope.getPage($stateParams.pageId);
      }
      $scope.category = shareParams.getCategory();
    });

    $scope.getPage = function (id) {
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
    };

  });
