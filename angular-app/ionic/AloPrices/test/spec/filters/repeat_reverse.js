'use strict';

describe('Filter: repeatReverse', function () {

  // load the filter's module
  beforeEach(module('aloPricesApp'));

  // initialize a new instance of the filter before each test
  var repeatReverse;
  beforeEach(inject(function ($filter) {
    repeatReverse = $filter('repeatReverse');
  }));

  it('should return the input prefixed with "repeatReverse filter:"', function () {
    var text = 'angularjs';
    expect(repeatReverse(text)).toBe('repeatReverse filter: ' + text);
  });

});
