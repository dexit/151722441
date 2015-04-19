'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PageVoteSearchCtrl
 * @description
 * # PageVoteSearchCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PageVoteSearchCtrl', function ($scope, $rootScope, $http, $location, $cordovaKeyboard, appGlobal, shareParams) {
    $scope.pages = [];
    $scope._page = 0;
    $scope.last_request = '';
    $scope.loading = true;

    $scope.gotoVotePage = function (index) {
      if ($scope.pages[index]) {
        shareParams.setVote($scope.pages[index]);
      }

      $location.path('/page/vote/' + $scope.pages[index].id);
    };

    $scope.gotoPageLink = function (index) {
      var url = '';
      if ($scope.pages[index]) {
        if ($rootScope.allowScheme) {
          url = $scope.pages[index].app_page_link;
        } else {
          url = $scope.pages[index].page_link;
        }
      }
      $rootScope.gotoLink(url);
    };

    $scope.init = function () {
      $('#dln_search_page').on('change', function () {
        var searchVal = $(this).val();

        if (! searchVal) {
          return false;
        }

        // Hide keyboard
        if (window.cordova && window.cordova.plugins.Keyboard) {
          $cordovaKeyboard.close();
        }

        $rootScope.showLoading('Đang tải');

        var url = appGlobal.host + '/helper/search_vote?q=' + searchVal;
        $http.get(url)
          .success(function (resp) {
            $rootScope.hideLoading();
            $scope.loading = false;

            if (resp.status === 'success') {
              var pages = [];
              angular.forEach(resp.data, function (item) {
                pages.push(item);
              });
              $scope.pages = pages;
            }
          });
      });
    };
    $scope.init();
  });
