'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:CategoryCtrl
 * @description
 * # CategoryCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('CategoryCtrl', function ($scope, $location, fCache) {
    $scope.categories = [];

    $scope.gotoPages = function (index) {
      if (! index) {
        return;
      }

      $location.path('/category/' + $scope.categories[index].id);
    };

    $scope.init = function () {
      fCache.init(function () {
        $scope.categories = fCache.getCategories();
      });
    };

    $scope.init();

  });
