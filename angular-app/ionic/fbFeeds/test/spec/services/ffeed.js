'use strict';

describe('Service: fFeed', function () {

  // load the service's module
  beforeEach(module('fbFeedsApp'));

  // instantiate service
  var fFeed;
  beforeEach(inject(function (_fFeed_) {
    fFeed = _fFeed_;
  }));

  it('should do something', function () {
    expect(!!fFeed).toBe(true);
  });

});
