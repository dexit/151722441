'use strict';

/**
 * @ngdoc directive
 * @name fbFeedsApp.directive:scrollInfitine
 * @description
 * # scrollInfitine
 */
angular.module('fbFeedsApp')
  .directive('scrollInfitine', function () {
    return {
      restrict: 'A',
      link: function postLink(scope, element, attrs) {

        var timeout = null;
        /* Add listener scroll event for make infinite scroll */
        element.bind('scroll', function(e) {
          clearTimeout(timeout);
          timeout = setTimeout(function () {

            var callbackInfinite = attrs.callbackInfinite;
            var scrollWapper = attrs.scrollWapper;

            if (! callbackInfinite || ! scrollWapper) {
              return false;
            }

            /* Fire callback function in end of scroll wrapper */
            if ($(element).scrollTop() + $(element).height() >= $(scrollWapper).height()) {
              scope.$apply(callbackInfinite);
            }
          }, 75);
        });

      }
    };
  });
