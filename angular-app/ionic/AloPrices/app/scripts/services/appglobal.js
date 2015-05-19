'use strict';

/**
 * @ngdoc service
 * @name aloPricesApp.appGlobal
 * @description
 * # appGlobal
 * Service in the aloPricesApp.
 */
angular.module('aloPricesApp')
  .constant('appGlobal', {
    host: 'http://home.vivufb.com/api/v1',
    exrUid: 'storage_uid',
    exrSavedTypes: 'exr_saved_types',
    exrSavedCurrencies: 'exr_saved_currencies',
    exrSavedCheckedCurrency: 'exr_saved_currencies_checked',
    exrCachedListCurrency: 'exr_cached_list_currency'
  });
