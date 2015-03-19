'use strict';

/**
 * @ngdoc function
 * @name fbFeedApp.controller:TestCtrl
 * @description
 * # TestCtrl
 * Controller of the fbFeedApp
 */
angular.module('fbFeedApp')
  .controller('TestCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
