'use strict';

describe('Controller: ExchangeExchangeAddCtrl', function () {

  // load the controller's module
  beforeEach(module('aloPricesApp'));

  var ExchangeExchangeAddCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ExchangeExchangeAddCtrl = $controller('ExchangeExchangeAddCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
