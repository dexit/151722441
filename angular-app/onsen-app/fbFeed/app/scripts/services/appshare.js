'use strict';

/**
 * @ngdoc service
 * @name fbFeedApp.appShare
 * @description
 * # appShare
 * Factory in the fbFeedApp.
 */
angular.module('fbFeedApp')
  .factory('appShare', function () {
    return {
      data: {
        title : 'Default Title'
      },
      updateTitle: function (title) {
        this.data.title = title;
      }
    };
  });
