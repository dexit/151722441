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
    var isSupported = false;
    var page = 0;
    var dln_category_ids = 'dln_category_ids';
    var dln_category_cache = 'dln_category_cache';
    var category_ids = '';

    $scope.gotoFeeds = function () {
      var category_ids_selected = [];
      $('#dln_category_filter input:checked').each(function () {
        category_ids_selected.push($(this).val());
      });

      if (! angular.equals(category_ids_selected, category_ids)) {
        if (localStorageService.isSupported) {
          localStorageService.set(dln_category_ids, category_ids_selected);
        }

        $rootScope.$emit('onFeedRefreshFeeds', null);
      }

      $ionicHistory.goBack();
    };

    $scope.parseObj = function (data) {
      angular.forEach(data, function (item) {
        item.checked = false;

        angular.forEach(category_ids, function (cat) {
          if (item.id === cat) {
            item.checked = true;
          }
        });

        $scope.categories.push(item);
      });

      $rootScope.hideLoading();
    };

    $scope.getCategory = function () {
      // Check category exists in cache
      if (isSupported && localStorageService.get(dln_category_cache)) {
        var category_cache = localStorageService.get(dln_category_cache);
        var data = null;
        if (typeof(category_cache) === 'string') {
          data = JSON.parse(dln_category_cache);
        } else {
          data = category_cache;
        }

        $scope.parseObj(data);
      } else {
        $http.get(appGlobal.host + '/category?page=' + page)
          .success(function (resp) {
            $scope.loading = false;
            if (resp.status === 'success') {
              localStorageService.set(dln_category_cache, JSON.stringify(resp.data));

              $scope.parseObj(resp.data);
            }
            page += 1;
          })
          .error(function (data, status, headers, config) {
            $scope.loading = false;
            console.log(data, status, headers, config);
            $rootScope.hideLoading();
          });
      }
    };

    $scope.$on('$ionicView.enter', function (e, args) {
      $rootScope.showLoading();
      isSupported = localStorageService.isSupported;
      if (isSupported) {
        category_ids = localStorageService.get(dln_category_ids);
      }
      $scope.getCategory();
    });
  });
