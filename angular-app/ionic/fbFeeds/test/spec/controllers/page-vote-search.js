'use strict';

describe('Controller: PageVoteSearchCtrl', function () {

  // load the controller's module
  beforeEach(module('fbFeedsApp'));

  var PageVoteSearchCtrl,
    scope;

  // Initialize the controller and a mock scope
  beforeEach(inject(function ($controller, $rootScope) {
    scope = $rootScope.$new();
    PageVoteSearchCtrl = $controller('PageVoteSearchCtrl', {
      $scope: scope
    });
  }));

  it('should attach a list of awesomeThings to the scope', function () {
    expect(scope.awesomeThings.length).toBe(3);
  });
});
