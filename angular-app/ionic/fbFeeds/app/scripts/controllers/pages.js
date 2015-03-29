'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PagesCtrl
 * @description
 * # PagesCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PagesCtrl', function ($scope, fCache) {
    $scope.pages = [];
    $scope._page = 0;
    $scope._lastRequest = '';
    $scope._loading = true;

    $scope.$on('ngRepeatFinished', function() {
      $('img.lazy-images:not(.active)').each(function () {
        $(this).lazyload({
          effect : 'fadeIn'
        });
        $(this).trigger('appear');
        $(this).addClass('active');
      });
    });

    $scope.init = function () {
      fCache.init(function () {
        var pages = [];
        if (fCache.getPages().length) {
          angular.forEach(fCache.getPages(), function (item) {
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
