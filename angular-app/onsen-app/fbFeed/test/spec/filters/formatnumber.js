'use strict';

describe('Filter: formatNumber', function () {

  // load the filter's module
  beforeEach(module('fbFeedApp'));

  // initialize a new instance of the filter before each test
  var formatNumber;
  beforeEach(inject(function ($filter) {
    formatNumber = $filter('formatNumber');
  }));

  it('should return the input prefixed with "formatNumber filter:"', function () {
    var text = 'angularjs';
    expect(formatNumber(text)).toBe('formatNumber filter: ' + text);
  });

});
