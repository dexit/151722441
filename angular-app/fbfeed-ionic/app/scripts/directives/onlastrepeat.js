'use strict';

/**
 * @ngdoc directive
 * @name fbfeedIonicApp.directive:onLastRepeat
 * @description
 * # onLastRepeat
 */
angular.module('fbfeedIonicApp')
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
