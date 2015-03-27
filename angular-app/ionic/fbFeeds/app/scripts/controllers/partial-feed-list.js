'use strict';

/**
 * @ngdoc function
 * @name fbFeedsApp.controller:PartialFeedsCtrl
 * @description
 * # PartialFeedsCtrl
 * Controller of the fbFeedsApp
 */
angular.module('fbFeedsApp')
  .controller('PartialFeedsCtrl', function ($scope, $http, $rootScope, $location, appGlobal, localStorageService, shareParams, fCache) {
    $scope.feeds = [];
    var page = 0;
    var last_request = '';
    $scope.loading = true;
    $scope.allowScheme = false;

    $scope.toTimeZone = function (time) {
      return moment(time).add(7, 'hours');
    };

    $scope.gotoPage = function (index) {
      if (! $scope.feeds[index].page_id) {
        /*shareParams.setPage($scope.feeds[index].page);
        shareParams.setCategory($scope.feeds[index].category);*/
        return false;
      }

      $location.path('/pages/' + $scope.feeds[index].page_id);
    };

    $scope.gotoLink = function (url) {
      window.open(url, '_system', 'location=yes,toolbar=yes');
    };

    $scope.requestFeeds = function ($done) {
      if ($scope.loading) {
        return false;
      }

      /* Get category_ids */
      var category_ids = [];
      if (localStorageService.isSupported && localStorageService.get('dln_category_ids')) {
        category_ids = localStorageService.get('dln_category_ids');
      }

      var page_id = 0;
      if (localStorageService.isSupported && localStorageService.get('dln_page_id')) {
        page_id = localStorageService.get('dln_page_id');
      }

      $rootScope.showLoading('Đang tải!');
      /* Abort last request same */
      var url = appGlobal.host + '/feeds?page=' + page + '&category_ids=' + category_ids.join(',') + '&page_id=' + page_id;

      if (last_request !== '' && last_request === url) {
        return;
      }

      $http.get(url)
        .success(function (resp) {
          $scope.loading = false;
          if (resp.status === 'success') {
            last_request = url;

            angular.forEach(resp.data, function (item) {
              /* Find page relate in cache */
              item.page = fCache.findPageById(item.page_id);
              item.category = fCache.findCategoryById(item.category_id);

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

    $scope.scollGetFeeds = function () {
      if ($scope.loading) {
        return false;
      }

      $scope.requestFeeds();
    };

    $scope.refreshFeeds = function ($done) {
      page = 0;
      $scope.feeds = [];
      $scope.requestFeeds($done);
    };

    $scope.$on('ngRepeatFinished', function () {
      /*window.$$('img.lazy').trigger('lazy');*/
      $('img.lazy-images:not(.active)').each(function () {
        $(this).lazyload({
          effect: 'fadeIn'
        });
        $(this).trigger('appear');
        $(this).addClass('active');
      });
    });

    $scope.$on('onRefreshFeeds', function (e, args) {
      $scope.refreshFeeds();
    });

    $rootScope.$on('onRequestFeeds', function (e, args) {
      $scope.loading = false;
    });

  });
