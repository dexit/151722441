'use strict';

describe('Controller: ExchangeAddCtrl', function () {

  // load the controller's module
  beforeEach(module('aloPricesApp'));

  var ExchangeAddCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ExchangeAddCtrl = $controller('ExchangeAddCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
