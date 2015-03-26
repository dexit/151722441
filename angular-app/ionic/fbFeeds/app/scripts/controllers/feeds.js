'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:FeedsCtrl
 * @description
 * # FeedsCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('FeedsCtrl', function ($scope, $http, $location, $rootScope, appGlobal, localStorageService, shareParams) {
    $scope.feeds = [];
    var page = 0;
    var last_request = '';
    $scope.loading = false;
    $scope.allowScheme = false;

    $scope.init = function () {
      /*$('#dln_scroll_wrapper').on('scroll', function (e) {
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

    $scope.gotoPage = function (index) {
      if ($scope.feeds[index].page) {
        shareParams.setPage($scope.feeds[index].page);
        shareParams.setCategory($scope.feeds[index].category);
      }

      $location.path('/pages/' + index);
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

      /* Get category_ids */
      var category_ids = [];
      if (localStorageService.isSupported && localStorageService.get('dln_category_ids')) {
        category_ids = localStorageService.get('dln_category_ids');
      }

      /* Abort last request same */
      var url = appGlobal.host + '/feeds?page=' + page + '&category_ids=' + category_ids.join(',');

      /*if (last_request !== '' && last_request === url) {
        return;
      }*/

      $rootScope.showLoading('Đang tải!');
      $http.get(url)
        .success(function (resp) {
          $scope.loading = false;
          if (resp.status === 'success') {
            last_request = url;

            angular.forEach(resp.data, function (item) {
              var obj = {};
              obj.created_at = $scope.toTimeZone(item.created_at);
              if ($rootScope.allowScheme) {
                obj.link = item.app_link;
                obj.page_link = item.page.app_page_link;
              } else {
                obj.link = item.link;
                obj.page_link = item.page.page_link;
              }
              switch (item.type) {
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
                  obj.font_type = 'fa fa-newspaper-o';
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
          window.alert('Không thể lấy tin, xin vui lòng thử lại!');
          $rootScope.hideLoading();
          if ($done) {
            $done();
          }
        });
    };

    $rootScope.$on('onRefreshFeeds', function (e, args) {
      $scope.refreshFeeds();
    });

    $scope.$on('ngRepeatFinished', function() {
      /*window.$$('img.lazy').trigger('lazy');*/
      $('img.lazy-images:not(.active)').each(function () {
        $(this).lazyload({
          effect : 'fadeIn'
        });
        $(this).trigger('appear');
        $(this).addClass('active');
      });
    });

  });
