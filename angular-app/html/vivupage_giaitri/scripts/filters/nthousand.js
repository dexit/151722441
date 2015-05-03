'use strict';

/**
 * @ngdoc filter
 * @name fbFeedsApp.filter:nThousand
 * @function
 * @description
 * # nThousand
 * Filter in the fbFeedsApp.
 */
angular.module('fbFeedsApp')
  .filter('nThousand', function () {
    return function(input) {
      var num = parseFloat(input);
      if (num >= 1000000000) {
        return (num / 1000000000).toFixed(1) + 'g';
      }
      if (num >= 1000000) {
        return (num / 1000000).toFixed(1) + 'm';
      }
      if (num >= 1000) {
        return (num / 1000).toFixed(1) + 'k';
      }
      return num;
    };
  });
