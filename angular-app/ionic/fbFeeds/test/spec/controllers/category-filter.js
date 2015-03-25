'use strict';

describe('Controller: CategoryFilterCtrl', function () {

  // load the controller's module
  beforeEach(module('fbFeedsApp'));

  var CategoryFilterCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    CategoryFilterCtrl = $controller('CategoryFilterCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
