'use strict';

describe('Service: models/deviceModel', function () {

  // load the service's module
  beforeEach(module('aloPricesApp'));

  // instantiate service
  var models/deviceModel;
  beforeEach(inject(function (_models/deviceModel_) {
    models/deviceModel = _models/deviceModel_;
  }));

  it('should do something', function () {
    expect(!!models/deviceModel).toBe(true);
  });

});
