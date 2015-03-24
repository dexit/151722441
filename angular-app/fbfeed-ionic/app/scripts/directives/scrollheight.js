'use strict';

/**
 * @ngdoc directive
 * @name fbfeedIonicApp.directive:scrollHeight
 * @description
 * # scrollHeight
 */
angular.module('fbfeedIonicApp')
  .directive('scrollHeight', function ($window) {
    return {
      restrict: 'A',
      link: function postLink(scope, element) {
        var height = '200px';
        element.css({
          width: '100%'
        });

        scope.onResizeFunction = function () {
          var hWindow = parseInt($window.innerHeight);
          var hToolbar = parseInt(jQuery('#dln_tabs_wrapper .md-header').height());

          if (hWindow && hToolbar) {
            height = hWindow - hToolbar + 'px';
          }

          element.css({
            'height' : height
          });
        };
        scope.onResizeFunction();

        angular.element(window).bind('resize', function () {
          scope.onResizeFunction();
          scope.$apply();
        });
      }
    };
  });
