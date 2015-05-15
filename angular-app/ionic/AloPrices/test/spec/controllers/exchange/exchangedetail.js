'use strict';

describe('Controller: ExchangeExchangedetailCtrl', function () {

  // load the controller's module
  beforeEach(module('aloPricesApp'));

  var ExchangeExchangedetailCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ExchangeExchangedetailCtrl = $controller('ExchangeExchangedetailCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
