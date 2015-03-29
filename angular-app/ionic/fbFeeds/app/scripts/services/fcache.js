'use strict';

/**
 * @ngdoc service
 * @name fbFeedsApp.fCache
 * @description
 * # fCache
 * Factory in the fbFeedsApp.
 */
angular.module('fbFeedsApp')
  .factory('fCache', function ($http, $rootScope, appGlobal) {

    var cache = {};

    /* Public API here */
    return {

      /* Initialize factory */
      init: function (next) {
        if (! angular.equals({}, cache)) {
          next();
          return;
        }

        /* Get cache from server */
        var url = appGlobal.host + '/cache';
        $rootScope.showLoading('Đang tải...');
        $http.get(url)
          .success(function (resp) {
            $rootScope.hideLoading();
            if (resp.status === 'success') {
              cache.categories = resp.data.category;
              cache.pages = resp.data.page;
              next();
            }
          })
          .error(function (data, status, headers, config) {
            console.log(data, status, headers, config);
            $rootScope.hideLoading();
          });

        return cache;
      },

      /* Find page by id */
      findPageById: function (id) {
        var _return = null;
        angular.forEach(cache.pages, function (item) {
          if (item.id === id) {
            _return = item;
          }
        });

        return _return;
      },

      /* Find category by id */
      findCategoryById: function (id) {
        var _return = null;

        angular.forEach(cache.categories, function (item) {
          if (item.id === id) {
            _return = item;
          }
        });

        return _return;
      },

      /* Get pages */
      getPages: function () {
        return cache.pages;
      }

    };
  });
