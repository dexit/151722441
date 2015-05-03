/**
 * Created by DinhLN on 26/4/2015.
 */
define([], function () {
  'use strict';

  var CONFIG = null;

  var globalServices = {

    /**
     * Initialize for global services.
     *
     * @return void
     */
    init: function () {
      if (! CONFIG) {
        CONFIG = {};
        CONFIG.currentUser = {};
        if (localStorage.getItem('sid')) {
          CONFIG.currentUser.sid = localStorage.getItem('sid');
        }
        if (localStorage.getItem('user')) {
          CONFIG.currentUser = JSON.parse(localStorage.getItem('user'));
        }
      }
    },

    /**
     * Get current user.
     *
     * @returns {{}|*}
     */
    getCurrentUser: function () {
      return CONFIG.currentUser;
    },

    /**
     * Get Sid.
     *
     * @returns {*}
     */
    getSid: function(){
      var m = $$.parseUrlQuery(window.location.href || '');
      return m.sid || localStorage.getItem('sid');
    },

    /**
     * Set current user.
     *
     * @param sid
     * @param user
     */
    setCurrentUser: function(sid, user){
      CONFIG.currentUser = user;
      localStorage.setItem('user', JSON.stringify(user));
      localStorage.setItem('sid', sid);
    },

    /**
     * Remove current user.
     *
     * @return void
     */
    removeCurrentUser: function(){
      CONFIG.currentUser = {};
      localStorage.removeItem('user');
      localStorage.removeItem('sid');
    },

    /**
     * Check current user is login.
     *
     * @returns boolean
     */
    isLogin: function(){
      return (CONFIG.currentUser && localStorage.getItem('sid'));
    }

  };

  /* Init global services */
  globalServices.init();

  return globalServices;
});