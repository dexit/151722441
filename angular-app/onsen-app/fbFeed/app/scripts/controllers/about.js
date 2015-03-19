'use strict';

/**
 * @ngdoc function
 * @name fbFeedApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the fbFeedApp
 */
angular.module('fbFeedApp')
  .controller('AboutCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
