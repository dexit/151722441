'use strict';

describe('Directive: googleAdsense', function () {

  // load the directive's module
  beforeEach(module('vivupageApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<google-adsense></google-adsense>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the googleAdsense directive');
  }));
});
