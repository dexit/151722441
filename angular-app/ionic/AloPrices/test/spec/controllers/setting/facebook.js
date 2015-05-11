'use strict';

describe('Controller: SettingFacebookCtrl', function () {

  // load the controller's module
  beforeEach(module('aloPricesApp'));

  var SettingFacebookCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    SettingFacebookCtrl = $controller('SettingFacebookCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
