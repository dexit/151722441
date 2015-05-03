/**
 * Created by DinhLN on 26/4/2015.
 */
define(['appFunc', 'ajax', 'GS', 'i18n!nls/lang', 'TM'], function (appFunc, ajax, GS, i18n, TM) {
  'use strict';

  var registerCtrl = {

    /**
     * Init for login controller.
     *
     * @return void
     */
    init: function () {
      /* Hide toolbar for login view */
      appFunc.hideToolbar();

    },

    /**
     * i18n format for login view.
     *
     * @param content
     * @returns {*}
     */
    i18next: function (content) {
      var renderData = {
        appName: i18n.app.name
      };

      var output = TM.renderTpl(content, renderData);
      return output;
    }

  };

  return registerCtrl;
});