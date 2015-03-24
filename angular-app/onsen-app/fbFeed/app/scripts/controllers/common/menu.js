'use strict';

/**
 * @ngdoc function
 * @name fbFeedApp.controller:CommonMenuCtrl
 * @description
 * # CommonMenuCtrl
 * Controller of the fbFeedApp
 */
angular.module('fbFeedApp')
  .controller('CommonMenuCtrl', function ($scope, $mdSidenav, $log, appShare) {

    $scope.shareData = appShare.data;

    $scope.closeNav = function() {
      $mdSidenav('left').close()
        .then(function(){
          $log.debug("close LEFT is done");
        });
    };

    $scope.toggleMenu = function () {
      $mdSidenav('menu_nav').toggle()
        .then(function () {
          $log.debug("toggle left is done");
        });
    };
  });
