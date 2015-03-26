'use strict';

describe('Service: shareParams', function () {

  // load the service's module
  beforeEach(module('fbFeedsApp'));

  // instantiate service
  var shareParams;
  beforeEach(inject(function (_shareParams_) {
    shareParams = _shareParams_;
  }));

  it('should do something', function () {
    expect(!!shareParams).toBe(true);
  });

});
