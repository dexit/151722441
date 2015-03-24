'use strict';

describe('Directive: scrollHeight', function () {

  // load the directive's module
  beforeEach(module('fbfeedIonicApp'));

  var element,
    scope;

  beforeEach(inject(function ($rootScope) {
    scope = $rootScope.$new();
  }));

  it('should make hidden element visible', inject(function ($compile) {
    element = angular.element('<scroll-height></scroll-height>');
    element = $compile(element)(scope);
    expect(element.text()).toBe('this is the scrollHeight directive');
  }));
});
