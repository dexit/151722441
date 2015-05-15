'use strict';

describe('Controller: ExchangeExchangeDetailCtrl', function () {

  // load the controller's module
  beforeEach(module('aloPricesApp'));

  var ExchangeExchangeDetailCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ExchangeExchangeDetailCtrl = $controller('ExchangeExchangeDetailCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
