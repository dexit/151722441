'use strict';

describe('Controller: PageVoteCtrl', function () {

  // load the controller's module
  beforeEach(module('fbFeedsApp'));

  var PageVoteCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PageVoteCtrl = $controller('PageVoteCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
