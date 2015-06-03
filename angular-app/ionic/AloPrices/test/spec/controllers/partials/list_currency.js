'use strict';

describe('Controller: PartialsListCurrencyCtrl', function () {

  // load the controller's module
  beforeEach(module('aloPricesApp'));

  var PartialsListCurrencyCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PartialsListCurrencyCtrl = $controller('PartialsListCurrencyCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
