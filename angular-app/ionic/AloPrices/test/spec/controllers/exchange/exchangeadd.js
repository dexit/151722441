'use strict';

describe('Controller: ExchangeExchangeaddCtrl', function () {

  // load the controller's module
  beforeEach(module('aloPricesApp'));

  var ExchangeExchangeaddCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ExchangeExchangeaddCtrl = $controller('ExchangeExchangeaddCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
