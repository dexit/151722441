'use strict';

/**
 * @ngdoc directive
 * @name fbFeedApp.directive:onLastRepeat
 * @description
 * # onLastRepeat
 */
angular.module('fbFeedApp')
  .directive('onLastRepeat', function ($timeout) {
    return {
      restrict: 'A',
      link: function (scope) {
        if (scope.$last === true) {
          $timeout(function () {
            scope.$emit('ngRepeatFinished');
          });
        }
      }
    };
  });
