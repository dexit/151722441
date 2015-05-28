'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PagesCtrl
 * @description
 * # PagesCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PagesCtrl', function ($scope, $rootScope, $stateParams, $location, fCache) {
    $scope.pages = [];
    $scope._page = 0;
    $scope._lastRequest = '';
    $scope._loading = true;

    $scope.gotoPage = function (index) {
      if (! $scope.pages[index]) {
        return false;
      }

      $location.path('/pages/' + $scope.pages[index].id);
    };

    $scope.gotoFBLink = function (index) {
      if (! $scope.pages[index]) {
        return false;
      }

      var url = '';
      if ($rootScope.allowScheme) {
        url = $scope.pages[index].app_page_link;
      } else {
        url = $scope.pages[index].page_link;
      }

      $rootScope.gotoLink(url);
    };

    $scope.init = function () {
      fCache.init(function () {
        var pages = [];
        if (fCache.getPages().length) {
          angular.forEach(fCache.getPages(), function (item) {

            if ($stateParams.categoryId && item.category_id !== $stateParams.categoryId) {
              return;
            }

            if (item.category_id) {
              item.category = fCache.findCategoryById(item.category_id);
            }

            pages.push(item);
          });
          $scope.pages = pages;
        }
      });
    };
    $scope.init();

  });
