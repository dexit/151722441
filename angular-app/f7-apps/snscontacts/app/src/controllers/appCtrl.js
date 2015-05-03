define(['appFunc','CM'],function(appFunc, CM){
  'use strict';

  /**
   * App controller.
   *
   * @type {{init: init, i18next: i18next, showToolbar: showToolbar}}
   */
  var appCtrl = {

    /**
     * Initialize for app controller
     *
     * @return void
     */
    init: function () {

    },

    /**
     * Initialize for i18n languages.
     *
     * @param viewName
     * @param content
     * @returns {*}
     */
    i18next: function(ctrlName, content){
      var output = CM.module(ctrlName).i18next(content);
      return output;
    },

    /*bindEven: function(){
      var bindings = [{
        element:document,
        selector:'div.item-image>img',
        event: 'click',
        handler: VM.module('appView').photoBrowser
      }];

      appFunc.bindEvents(bindings);
    },*/

    /**
     * Show toolbar for app controller
     *
     * @return void
     */
    showToolbar: function(){
      appFunc.showToolbar();
    }

  };

  /* Alway run app init */
  appCtrl.init();

  return appCtrl;
});