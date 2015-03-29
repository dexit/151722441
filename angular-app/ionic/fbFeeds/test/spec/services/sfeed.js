'use strict';

describe('Service: sFeed', function () {

  // load the service's module
  beforeEach(module('fbFeedsApp'));

  // instantiate service
  var sFeed;
  beforeEach(inject(function (_sFeed_) {
    sFeed = _sFeed_;
  }));

  it('should do something', function () {
    expect(!!sFeed).toBe(true);
  });

});
