/**
 * Created by DinhLN on 25/4/2015.
 */
'use strict';

define(['GS', 'CM'], function (GS, CM) {

  var router = {

    /**
     * Init for router.
     *
     * @return void
     */
    init: function () {
      $$(document).on('pageBeforeInit', function (e) {
        var page = e.detail.page;
        router.pageBeforeInit(page);
      });

      $$(document).on('pageAfterAnimation', function (e) {
        var page = e.detail.page;
        router.pageAfterAnimation(page);
      });
      GS.removeCurrentUser();

      if(! GS.isLogin()){
        mainView.router.loadPage('pages/account/login.html');
      }else{
        mainView.router.reloadPage('index.html');
      }
    },

    /**
     * Set callback for pageAfterAnimation
     *
     * @param page
     * @return void
     */
    pageAfterAnimation: function(page){
      var name = page.name;
      var from = page.from;
      var swipeBack = page.swipeBack;
      CM.module('appCtrl').showToolbar();
      if(name === 'main' || name === 'contact' || name === 'setting' ){
        if(from === 'left' && swipeBack){
          CM.module('appCtrl').showToolbar();
        }
      }
    },

    /**
     * Callback process for pageBeforeInit event.
     *
     * @param page
     * @return void
     */
    pageBeforeInit: function(page) {
      var name  = page.name;
      var query = page.query;
      var from = page.from;

      /*require(['build/views/' + name + '/'+ name + 'View'], function(module) {
        module.init(query);
      });*/
      switch(name) {
        case 'login':
          CM.module('loginCtrl').init();
          break;
        case 'register':
          CM.module('registerCtrl').init();
          break
      }
    },

    /**
     * Pre process for router.
     *
     * @param content
     * @param url
     * @returns {*}
     */
    preProcess: function(content, url){
      console.log(url);
      if(!url) return false;

      url = url.split('?')[0] ;

      var ctrlName;

      switch (url) {
        case 'index.html':
          ctrlName = 'appCtrl';
          break;
        case 'pages/account/login.html':
          ctrlName = 'loginCtrl';
          break;
        case 'pages/account/register.html':
          ctrlName = 'registerCtrl';
          break;
      }
      if (ctrlName) {
        var output = CM.module(ctrlName).i18next(content);
        return output;
      } else {
        alert('Please check!');
        return false;
      }
    }

  };

  return router;
});