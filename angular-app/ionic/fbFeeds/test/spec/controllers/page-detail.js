'use strict';

describe('Controller: PageDetailCtrl', function () {

  // load the controller's module
  beforeEach(module('fbFeedsApp'));

  var PageDetailCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PageDetailCtrl = $controller('PageDetailCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
