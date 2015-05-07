'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.appGlobal
 * @description
 * # appGlobal
 * Service in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .service('appGlobal', function () {
    host: 'http://home.vivufb.com/api/v1';
    exrUid: 'storage_uid';
  });
