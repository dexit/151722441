'use strict';

describe('Service: appGlobal', function () {

  // load the service's module
  beforeEach(module('aloPricesApp'));

  // instantiate service
  var appGlobal;
  beforeEach(inject(function (_appGlobal_) {
    appGlobal = _appGlobal_;
  }));

  it('should do something', function () {
    expect(!!appGlobal).toBe(true);
  });

});
