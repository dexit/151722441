'use strict';

describe('Service: cacheFactory', function () {

  // load the service's module
  beforeEach(module('fbFeedsApp'));

  // instantiate service
  var cacheFactory;
  beforeEach(inject(function (_cacheFactory_) {
    cacheFactory = _cacheFactory_;
  }));

  it('should do something', function () {
    expect(!!cacheFactory).toBe(true);
  });

});
