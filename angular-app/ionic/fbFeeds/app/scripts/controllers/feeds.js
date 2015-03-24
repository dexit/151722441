'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:FeedsCtrl
 * @description
 * # FeedsCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('FeedsCtrl', function ($scope, $http, $rootScope, appGlobal) {
    $scope.feeds = [];
    var page = 0;
    $scope.loading = false;
    $scope.allowScheme = false;

    $scope.init = function () {
      $('#dln_scroll_wrapper').on('scroll', function (e) {
        if ($(this).scrollTop() === 0) {
          $('#dln_pull_feed').removeAttr('disabled');
        } else {
          $('#dln_pull_feed').attr('disabled', 'disabled');
        }
      });

      /*window.mainView = window.f7.addView('.dln-view-main', {
        dynamicNavbar: true
      });*/
    };

    $scope.init();

    $scope.gotoLink = function (url) {
      console.log(url);
      window.open(url, '_system', 'location=yes,toolbar=yes');
    };

    $scope.toTimeZone = function (time) {
      return moment(time).add(7, 'hours');
    };

    $scope.refreshFeeds = function ($done) {
      page = 0;
      $scope.feeds = [];
      $scope.getFeeds($done);
    };

    $scope.getFeeds = function ($done) {
      if ($scope.loading) {
        return;
      }

      $rootScope.showLoading('Đang tải!');

      $http.get(appGlobal.host + '/feeds?page=' + page)
        .success(function (resp) {
          $scope.loading = false;
          if (resp.status === 'success') {

            angular.forEach(resp.data, function (item) {

              var obj = {};
              obj.profile_src = 'http://graph.facebook.com/' + item.page.fb_id + '/picture?type=small';
              obj.created_at = $scope.toTimeZone(item.created_at);
              if ($rootScope.allowScheme) {
                obj.link = item.app_link;
                obj.page_link = item.page.app_page_link;
              } else {
                obj.link = item.link;
                obj.page_link = 'http://m.facebook.com/' + item.page.fb_id;
              }
              switch (item.type) {
                case 'photo':
                  obj.font_type = 'camera retro icon';
                  break;
                case 'video':
                  obj.font_type = 'video play outline icon';
                  break;
                case 'link':
                  obj.font_type = 'unlink icon';
                  break;
                case 'status':
                  obj.font_type = 'newspaper icon';
                  break;
              }

              $scope.feeds.push(angular.extend({}, item, obj));
            });

          }
          $rootScope.hideLoading();
          page += 1;
          if ($done) {
            $done();
          }
        })
        .error(function (data, status, headers, config) {
          $scope.loading = false;
          console.log(data, status, headers, config);
          $rootScope.hideLoading();
          if ($done) {
            $done();
          }
        });
    };

    $scope.$on('ngRepeatFinished', function() {
      //window.$$('img.lazy').trigger('lazy');
      $('img.lazy-images').lazyload({
        effect : 'fadeIn'
      });
      $('img.lazy-images').trigger('appear');
    });

  });
