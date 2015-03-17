'use strict';
angular.module('dlnFeed')
  .controller('MainCtrl', function ($scope, Start, Config) {
    // bind data from service
    $scope.someData = Start.someData;
    $scope.env = Config.ENV;
  });
