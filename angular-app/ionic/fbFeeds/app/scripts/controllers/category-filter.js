'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:CategoryFilterCtrl
 * @description
 * # CategoryFilterCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('CategoryFilterCtrl', function ($scope, $rootScope, $http, $ionicHistory, appGlobal, localStorageService) {
    $scope.categories = [];
    var page = 0;

    $scope.gotoFeeds = function () {
      var category_id = '';
      $('#dln_category_filter input:checked').each(function () {
        category_id += $(this).val() + ',';
      });
      if (localStorageService.isSupported) {
        localStorageService.set('dln_category_id', category_id);
      }

      $ionicHistory.goBack();
    };

    $scope.getCategory = function () {
      $rootScope.showLoading();
      $http.get(appGlobal.host + '/category?page=' + page)
        .success(function (resp) {
          $scope.loading = false;
          if (resp.status === 'success') {
            angular.forEach(resp.data, function (item) {
              $scope.categories.push(item);
            });
          }
          $rootScope.hideLoading();
          page += 1;
        })
        .error(function (data, status, headers, config) {
          $scope.loading = false;
          console.log(data, status, headers, config);
          $rootScope.hideLoading();
        });
    };

    $scope.getCategory();
  });
