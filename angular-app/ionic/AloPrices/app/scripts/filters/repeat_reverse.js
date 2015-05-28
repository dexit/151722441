'use strict';

/**
 * @ngdoc filter
 * @name aloPricesApp.filter:repeatReverse
 * @function
 * @description
 * # repeatReverse
 * Filter in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .filter('repeatReverse', function () {
    return function (items) {
      return items.slice().reverse();
    };
  });
