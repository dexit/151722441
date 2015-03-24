'use strict';

describe('Filter: nThousand', function () {

  // load the filter's module
  beforeEach(module('fbFeedApp'));

  // initialize a new instance of the filter before each test
  var nThousand;
  beforeEach(inject(function ($filter) {
    nThousand = $filter('nThousand');
  }));

  it('should return the input prefixed with "nThousand filter:"', function () {
    var text = 'angularjs';
    expect(nThousand(text)).toBe('nThousand filter: ' + text);
  });

});
