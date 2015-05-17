'use strict';

describe('Controller: GoldCtrl', function () {

  // load the controller's module
  beforeEach(module('aloPricesApp'));

  var GoldCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    GoldCtrl = $controller('GoldCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
