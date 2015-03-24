'use strict';

describe('Service: dataShare', function () {

  // load the service's module
  beforeEach(module('fbFeedApp'));

  // instantiate service
  var dataShare;
  beforeEach(inject(function (_dataShare_) {
    dataShare = _dataShare_;
  }));

  it('should do something', function () {
    expect(!!dataShare).toBe(true);
  });

});
