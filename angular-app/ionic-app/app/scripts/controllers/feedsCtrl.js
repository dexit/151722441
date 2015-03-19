/**
 * Created by root on 17/03/2015.
 */
(function (module) {
  'use strict';

  module.controller('FeedsCtrl', ['$rootScope', '$http', '$scope', 'GLOB', '$ionicPopup', '$cordovaAppAvailability', '$ionicLoading', function ($rootScope, $http, $scope, GLOB, $ionicPopup, $cordovaAppAvailability, $ionicLoading) {
    $scope.feeds = [];
    var page = 0;
    $scope.loading = false;
    $scope.allowScheme = false;

    $scope.gotoLink = function (url) {
      console.log(url);
      window.open(url, '_system', 'location=yes,toolbar=yes');
    };

    $scope.removeFeed = function (index) {
      var confirmPopup = $ionicPopup.confirm({
        title: 'Xóa tin',
        template: 'Bạn có muốn xóa tin này không?'
      });
      confirmPopup.then(function (res) {
        if (res) {
          var item = $scope.feeds.splice(index, 1);
          item = item[0];
          $scope.addfeedDeletedCache(item.id);
        }
      });
    };

    $scope.addfeedDeletedCache = function (feedId) {
      if (!feedId) {
        return false;
      }
      var feeds_deleted = {};
      if (typeof(window.localStorage.feeds_deleted) !== undefined) {
        feeds_deleted = window.localStorage.feeds_deleted;
      }
      if (!feeds_deleted.indexOf(feedId)) {
        feeds_deleted.push(feedId);
        window.localStorage.feeds_deleted = feeds_deleted;
      }
      console.log(window.localStorage.feeds_deleted);
    };

    $scope.checkFeedDeleted = function (feedId) {
      if (!feedId) {
        return false;
      }
      var feeds_deleted = [];
      if (typeof(window.localStorage.feeds_deleted) !== undefined) {
        feeds_deleted = window.localStorage.feeds_deleted;
      }
      if (typeof(feeds_deleted) !== undefined) {
        for (var i = 0; i < feeds_deleted.length; i++) {
          if (feeds_deleted[i] === feedId) {
            return true;
          }
        }
      }

      return false;
    };

    $scope.show = function() {
      $ionicLoading.show({
        template: 'Đang tải...'
      });
    };

    $scope.hide = function(){
      $ionicLoading.hide();
    };

    document.addEventListener('deviceready', function () {
      var scheme;
      if (device.platform === 'iOS') {
        scheme = 'fb://';
      }
      else if (device.platform === 'Android') {
        scheme = 'com.facebook.katana';
      }
      $cordovaAppAvailability.check(scheme)
        .then(function () {
          $scope.allowScheme = true;
        }, function () {
          $scope.allowScheme = false;
        });
    }, false);

    $scope.onRefreshFeeds = function () {
      page = 0;
      $scope.feeds = [];
      $scope.getFeeds();
    };

    $scope.getFeeds = function () {
      if ($scope.loading) {
        return;
      }
      $scope.show();
      $http.get(GLOB.host + '/feeds?page=' + page)
        .success(function (resp) {
          $scope.loading = false;
          if (resp.status === 'success') {
            angular.forEach(resp.data, function (item) {
              var obj = {};
              obj.id = item.id;
              obj.profile_src = 'http://graph.facebook.com/' + item.page.fb_id + '/picture?type=small';
              obj.profile_name = item.page.name;
              obj.created_at = $scope.toTimeZone(item.created_at);
              if ($scope.allowScheme) {
                obj.link = item.app_link;
                obj.page_link = item.page.app_page_link;
              } else {
                obj.link = item.link;
                obj.page_link = 'http://m.facebook.com/' + item.page.fb_id;
              }
              obj.message = item.message;
              obj.photo = item.photo;
              obj.like_count = item.like_count;
              obj.comment_count = item.comment_count;
              obj.share_count = item.share_count;
              obj.type = item.type;
              obj.category_name = item.category.name;
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

              $scope.feeds.push(obj);
            });
          }
          $scope.hide();
          page += 1;
        })
        .error(function (data, status, headers, config) {
          $scope.loading = false;
          console.log(data, status, headers, config);
          $scope.hide();
        });
    };

    $scope.getFeeds();

    $scope.toTimeZone = function (time) {
      return moment(time).add(7, 'hours');
    };

  }]);

}(angular.module('dlnFeed.feedsCtrl', [])));
