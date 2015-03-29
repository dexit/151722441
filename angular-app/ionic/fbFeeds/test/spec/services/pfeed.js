'use strict';

describe('Service: pFeed', function () {

  // load the service's module
  beforeEach(module('fbFeedsApp'));

  // instantiate service
  var pFeed;
  beforeEach(inject(function (_pFeed_) {
    pFeed = _pFeed_;
  }));

  it('should do something', function () {
    expect(!!pFeed).toBe(true);
  });

});
