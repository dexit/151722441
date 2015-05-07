'use strict';

describe('Service: deviceModel', function () {

  // load the service's module
  beforeEach(module('aloPricesApp'));

  // instantiate service
  var deviceModel;
  beforeEach(inject(function (_deviceModel_) {
    deviceModel = _deviceModel_;
  }));

  it('should do something', function () {
    expect(!!deviceModel).toBe(true);
  });

});
