'use strict';

/**
 * @ngdoc directive
 * @name vivupageApp.directive:googleAdsense
 * @description
 * # googleAdsense
 */
angular.module('fbFeedsApp')
  .directive('googleAdsense', function ($window, $compile) {
    var adSenseTpl = '<ins class="ad-div adsbygoogle responsive" style="display:inline-block;width:468px;height:60px" data-ad-client="ca-pub-9356823423719215" data-ad-slot="2019801680"></ins>';
    return {
      template: adSenseTpl,
      restrict: 'A',
      transclude: true,
      replace: false,
      link: function postLink(scope, element, iAttrs) {
        element.html('');
        element.append(angular.element($compile(adSenseTpl)(scope)));
        if (!$window.adsbygoogle) {
          $window.adsbygoogle = [];
        }
        $window.adsbygoogle.push({});
      }
    };
  });
