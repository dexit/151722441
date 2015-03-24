'use strict';

describe('Service: appDefine', function () {

  // load the service's module
  beforeEach(module('fbFeedApp'));

  // instantiate service
  var appDefine;
  beforeEach(inject(function (_appDefine_) {
    appDefine = _appDefine_;
  }));

  it('should do something', function () {
    expect(!!appDefine).toBe(true);
  });

});
