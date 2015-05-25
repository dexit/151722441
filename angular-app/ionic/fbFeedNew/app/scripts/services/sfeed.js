'use strict';

/**
 * @ngdoc service
 * @name fbFeedsApp.sFeed
 * @description
 * # sFeed
 * Service in the fbFeedsApp.
 */
angular.module('fbFeedsApp')
  .service('sFeed', function ($rootScope, $http, appGlobal, fCache, localStorageService) {

    var countRefresh = 0;

    this.toTimeZone = function (time) {
      return moment(time).add(7, 'hours');
    };

    this.getFeeds = function (_scope, isRefreshed) {
      var self = this;
      if (_scope.loading) {
        return;
      }

      /* Get category_ids */
      var category_ids = [];
      if (localStorageService.isSupported && localStorageService.get('dln_category_ids')) {
        category_ids = localStorageService.get('dln_category_ids');
      }

      /* Get page id */
      var page_id = 0;
      if (_scope.page_id) {
        page_id = _scope.page_id;
      }

      var type = ($rootScope.feedType !== 'unread') ? $rootScope.feedType : '';

      /* Abort last request same */
      var category_ids = (_scope.category_id) ? _scope.category_id : category_ids.join(',');
      var url = appGlobal.host + '/feeds?page=' + _scope._page + '&category_ids=' + category_ids + '&page_id=' + page_id + '&order=' + type;

      if (_scope.last_request !== '' && _scope.last_request === url) {
       return;
      }

      if (isRefreshed) {
        _scope.feeds = [];
      }

      $rootScope.showLoading('Đang tải...');

      _scope.last_request = url;
      $http.get(url)
        .success(function (resp) {
          _scope.loading = false;

          if (resp.status === 'success') {
            var cachedIds = localStorageService.get('dln_cached_ids') || [];

            // Clear cache if length > 400
            if (cachedIds.length >= 400) {
              cachedIds = [];
              localStorageService.set('dln_cached_ids', cachedIds);
            }

            angular.forEach(resp.data, function (item, index) {
              if ($rootScope.feedType === 'unread') {
                if (cachedIds.indexOf(item.id) >= 0) {
                  return false;
                }
              }

              if (cachedIds.indexOf(item.id) < 0 || cachedIds.length === 0) {
                cachedIds.push(item.id);
                localStorageService.set('dln_cached_ids', cachedIds);
              }
              /*if (index % 4 == 0) {
               var _new = {};
               _new.type = 'ads';
               _new.name = 'Test';
               _scope.feeds.push(_new);
               }*/
              /* Get page and category from cache */
              item.page = fCache.findPageById(item.page_id);
              item.category = fCache.findCategoryById(item.category_id);

              var obj = {};
              obj.created_at = self.toTimeZone(item.created_at);
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

              _scope.feeds.push(angular.extend({}, item, obj));
            });
          }
          $rootScope.hideLoading();
          _scope._page += 1;

          if (_scope.feeds.length === 0 && countRefresh <= 30) {
            countRefresh++;
            self.getFeeds(_scope, isRefreshed);
          }
        })
        .error(function (data, status, headers, config) {
          _scope.loading = false;

          console.log(data, status, headers, config);
          window.alert('Không thể lấy tin, xin vui lòng thử lại!');
          $rootScope.hideLoading();

        });
    };

  });
