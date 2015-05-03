'use strict';

describe('Controller: JsControllersLogincontrollerCtrl', function () {

  // load the controller's module
  beforeEach(module('snscontactApp'));

  var JsControllersLogincontrollerCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    JsControllersLogincontrollerCtrl = $controller('JsControllersLogincontrollerCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
