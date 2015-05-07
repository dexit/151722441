'use strict';

describe('Service: Currency', function () {

  // load the service's module
  beforeEach(module('aloPricesApp'));

  // instantiate service
  var Currency;
  beforeEach(inject(function (_Currency_) {
    Currency = _Currency_;
  }));

  it('should do something', function () {
    expect(!!Currency).toBe(true);
  });

});
