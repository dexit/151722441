'use strict';

/**
 * @ngdoc function
 * @name fbFeedApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the fbFeedApp
 */
angular.module('fbFeedApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
