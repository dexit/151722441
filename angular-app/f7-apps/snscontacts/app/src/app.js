(function () {
  var lang = localStorage.getItem('lang') || 'vi-vn';

  require.config({
    locale: lang,
    paths: {
      text: '../vendors/requirejs-text/text',
      i18n: '../vendors/requirejs-i18n/i18n',
      Framework7: '../vendors/framework7/dist/js/framework7.min',
      appFunc: 'utils/appFunc',
      ajax: 'utils/ajax',
      TM: 'utils/tplManager',
      lang: 'i18n!nls/lang',
      CM: 'controllers/_modules',
      GS: 'services/globalServices'
    },
    shim: {
      'Framework7': {exports: 'Framework7'}
    }
  });

  require(['Framework7','router','i18n!nls/lang','appFunc'], function (Framework7,router,i18n,appFunc) {

    var app = {

      /**
       * Init for app.
       *
       * @return void
       */
      initialize: function() {
        if(appFunc.isPhonegap()) {
          document.addEventListener('deviceready', this.onDeviceReady, false);
        }else{
          window.onload = this.onDeviceReady();
        }
      },

      /**
       * bind event for cordova device ready.
       *
       * @return void
       */
      onDeviceReady: function() {
        app.receivedEvent('deviceready');
      },

      /**
       * Callback event for device ready.
       *
       * @param event
       * @return void
       */
      receivedEvent: function(event) {
        switch (event) {
          case 'deviceready':
            app.initMainView();
            break;
        }
      },

      /**
       * Init for MainView
       *
       * @return void
       */
      initMainView: function () {
        window.$$ = Dom7;

        window.SNSContacts = new Framework7({
          pushState: true,
          popupCloseByOutside:false,
          animateNavBackIcon: true,
          modalTitle: i18n.global.modal_title,
          modalButtonOk: i18n.global.modal_button_ok,
          modalButtonCancel: i18n.global.cancel,
          preprocess: router.preProcess
        });

        window.mainView = SNSContacts.addView('#mainView', {
          dynamicNavbar: true
        });

        router.init();
      }

    };

    /* Init app */
    app.initialize();

  });

})();