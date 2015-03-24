'use strict';

describe('Controller: CommonMenuCtrl', function () {

  // load the controller's module
  beforeEach(module('fbFeedApp'));

  var CommonMenuCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    CommonMenuCtrl = $controller('CommonMenuCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
