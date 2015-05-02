'use strict';

describe('Directive: scrollInfitine', function () {

  // load the directive's module
  beforeEach(module('fbFeedsApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<scroll-infitine></scroll-infitine>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the scrollInfitine directive');
  }));
});
