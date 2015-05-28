'use strict';

/**
 * @ngdoc directive
 * @name fbFeedsApp.directive:onLastRepeat
 * @description
 * # onLastRepeat
 */
angular.module('fbFeedsApp')
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
