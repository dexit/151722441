'use strict';

describe('Service: deviceFactory', function () {

  // load the service's module
  beforeEach(module('aloPricesApp'));

  // instantiate service
  var deviceFactory;
  beforeEach(inject(function (_deviceFactory_) {
    deviceFactory = _deviceFactory_;
  }));

  it('should do something', function () {
    expect(!!deviceFactory).toBe(true);
  });

});
