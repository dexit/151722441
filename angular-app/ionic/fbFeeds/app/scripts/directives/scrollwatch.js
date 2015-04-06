'use strict';

/**
 * @ngdoc directive
 * @name fbFeedsApp.directive:scrollWatch
 * @description
 * # scrollWatch
 */
angular.module('fbFeedsApp')
  .directive('scrollWatch', function ($rootScope) {
    return function(scope, elem, attr) {
      var start = 0;
      var threshold = 150;
      var timeout = '';
      elem.bind('scroll', function(e) {
        clearTimeout(timeout);
        timeout = setTimeout(function () {
          if(e.currentTarget.scrollTop - start > threshold) {
            $rootScope.slideHeader = true;
          } else {
            $rootScope.slideHeader = false;
          }
          if ($rootScope.slideHeaderPrevious >= e.currentTarget.scrollTop - start) {
            $rootScope.slideHeader = false;
          }
          $rootScope.slideHeaderPrevious = e.currentTarget.scrollTop - start;
          $rootScope.$apply();
        }, 75);
      });
    };
  });
