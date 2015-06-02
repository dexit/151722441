'use strict';

describe('Controller: ExchangeDetailListJsCtrl', function () {

  // load the controller's module
  beforeEach(module('aloPricesApp'));

  var ExchangeDetailListJsCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    ExchangeDetailListJsCtrl = $controller('ExchangeDetailListJsCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
