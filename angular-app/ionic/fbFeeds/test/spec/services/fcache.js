'use strict';

describe('Service: fCache', function () {

  // load the service's module
  beforeEach(module('fbFeedsApp'));

  // instantiate service
  var fCache;
  beforeEach(inject(function (_fCache_) {
    fCache = _fCache_;
  }));

  it('should do something', function () {
    expect(!!fCache).toBe(true);
  });

});
