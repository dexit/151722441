/**
 * Created by root on 17/03/2015.
 */
(function (module) {
  'use strict';

  module.controller('FeedsCtrl', ['$rootScope', '$http', '$scope', 'GLOB', function ($rootScope, $http, $scope, GLOB) {
    $scope.feeds = [];
    var page = 0;
    $scope.loading = false;

    $scope.getFeeds = function () {
      if ($scope.loading) {
        return;
      }

      $http.get(GLOB.host + '/feeds?page=' + page)
        .success(function(resp) {
          $scope.loading = false;
          if (resp.status === 'success') {
            angular.forEach(resp.data, function (item) {
              var obj = {};
              obj.profile_src   = 'http://graph.facebook.com/' + item.page.fb_id + '/picture?type=small';
              obj.profile_name  = item.page.name;
              obj.created_at    = $scope.toTimeZone(item.created_at);
              if ($rootScope.checkPhonegapBrowser) {
                //obj.link      = item.link;
                obj.link      = item.app_link;
              } else {
                obj.link      = item.link;
              }
              obj.message       = item.message;
              obj.photo         = item.photo;
              obj.like_count    = item.like_count;
              obj.comment_count = item.comment_count;
              obj.share_count   = item.share_count;
              obj.type          = item.type;
              switch(item.type) {
                case 'photo':
                  obj.font_type = 'fa fa-camera-retro';
                  break;
                case 'video':
                  obj.font_type = 'fa fa-play-circle';
                  break;
                case 'link':
                  obj.font_type = 'fa fa-unlink';
                  break;
                case 'status':
                  obj.font_type = 'fa fa-comment-o';
                  break;
              }

              $scope.feeds.push(obj);
            });
          }
          $rootScope.hideLoading();
          page += 1;
        })
        .error(function(data, status, headers, config) {
          $scope.loading = false;
          console.log(data, status, headers, config);
          $rootScope.hideLoading();
        });
    };

    $scope.getFeeds();

    $scope.toTimeZone = function (time) {
      return moment(time).add(7, 'hours');
    };

  }]);

}(angular.module('dlnFeed.feedsCtrl', [])));
