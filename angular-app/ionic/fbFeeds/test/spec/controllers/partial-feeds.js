'use strict';

describe('Controller: PartialFeedsCtrl', function () {

  // load the controller's module
  beforeEach(module('fbFeedsApp'));

  var PartialFeedsCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PartialFeedsCtrl = $controller('PartialFeedsCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
