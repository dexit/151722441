/**
 * Created by DinhLN on 26/4/2015.
 */
define([
  'controllers/appCtrl',
  'controllers/loginCtrl',
  'controllers/registerCtrl'
], function (appCtrl, loginCtrl, registerCtrl) {
  'use strict';

  var modules = {
    module: function (name) {
      var controller;

      switch (name) {
        case 'appCtrl':
          controller = appCtrl;
          break;
        case 'loginCtrl':
          controller = loginCtrl;
          break;
        case 'registerCtrl':
          controller = registerCtrl;
          break;
      }

      return controller;

    }
  };

  return modules;

});