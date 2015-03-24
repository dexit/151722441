'use strict';

describe('Service: appShare', function () {

  // load the service's module
  beforeEach(module('fbFeedApp'));

  // instantiate service
  var appShare;
  beforeEach(inject(function (_appShare_) {
    appShare = _appShare_;
  }));

  it('should do something', function () {
    expect(!!appShare).toBe(true);
  });

});
