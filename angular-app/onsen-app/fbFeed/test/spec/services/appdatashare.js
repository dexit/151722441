'use strict';

describe('Service: appDataShare', function () {

  // load the service's module
  beforeEach(module('fbFeedApp'));

  // instantiate service
  var appDataShare;
  beforeEach(inject(function (_appDataShare_) {
    appDataShare = _appDataShare_;
  }));

  it('should do something', function () {
    expect(!!appDataShare).toBe(true);
  });

});
