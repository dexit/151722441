'use strict';

describe('Service: model/deviceModel', function () {

  // load the service's module
  beforeEach(module('aloPricesApp'));

  // instantiate service
  var model/deviceModel;
  beforeEach(inject(function (_model/deviceModel_) {
    model/deviceModel = _model/deviceModel_;
  }));

  it('should do something', function () {
    expect(!!model/deviceModel).toBe(true);
  });

});
