'use strict';

/**
 * @ngdoc service
 * @name fbFeedsApp.shareParams
 * @description
 * # shareParams
 * Service in the fbFeedsApp.
 */
angular.module('fbFeedsApp')
  .service('shareParams', function () {
    var data = {
      page: '',
      category: '',
      refreshFeed: false
    };
    return {
      setRefreshFeed: function (_value) {
        data.refreshFeed = _value;
      },

      getRefreshFeed: function () {
        return data.refreshFeed;
      },

      getCategory: function () {
        return data.category;
      },

      setCategory: function (obj) {
        data.category = obj;
      },

      getPage: function () {
        return data.page;
      },

      setPage: function(object) {
        data.page = object;
      }
    };
  });
