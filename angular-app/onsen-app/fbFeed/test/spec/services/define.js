'use strict';

describe('Service: define', function () {

  // load the service's module
  beforeEach(module('fbFeedApp'));

  // instantiate service
  var define;
  beforeEach(inject(function (_define_) {
    define = _define_;
  }));

  it('should do something', function () {
    expect(!!define).toBe(true);
  });

});
