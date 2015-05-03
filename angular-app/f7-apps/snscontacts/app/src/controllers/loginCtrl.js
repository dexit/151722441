/**
 * Created by DinhLN on 26/4/2015.
 */
define(['appFunc', 'ajax', 'GS', 'i18n!nls/lang', 'TM'], function (appFunc, ajax, GS, i18n, TM) {
  'use strict';

  var loginCtrl = {

    /**
     * Init for login controller.
     *
     * @return void
     */
    init: function () {
      /* Hide toolbar for login view */
      appFunc.hideToolbar();

      /* For click submit login button */
      $$('.login-submit').on('click', function (e) {
        e.preventDefault();

        loginCtrl.loginSubmit();
      });
    },

    /**
     * i18n format for login view.
     *
     * @param content
     * @returns {*}
     */
    i18next: function (content) {
      var renderData = {
        appName: i18n.app.name,
        loginnamePlaceholder: i18n.login.loginname_placeholder,
        passwordPlaceholder: i18n.login.password_placeholder,
        loginBtn: i18n.login.login_btn,
        signUp: i18n.login.sign_up,
        forgotPwd: i18n.login.forgot_pwd,
        language: i18n.global.language
      };

      var output = TM.renderTpl(content, renderData);
      return output;
    },

    /**
     * Login submit function.
     *
     * @return void
     */
    loginSubmit: function () {
      var loginName = $$('input.login-name').val();
      var password = $$('input.password').val();

      if(loginName === '' || password === ''){
        SNSContacts.alert(i18n.login.err_empty_input);
      }else if(!appFunc.isEmail(loginName)){
        SNSContacts.alert(i18n.login.err_illegal_email);
      }else{
        SNSContacts.showPreloader(i18n.login.login);

        /* Send ajax login request */
        ajax.simpleCall({
          func:'user_login',
          data:{
            loginname:loginName,
            password:password
          }
        },function(response){
          setTimeout(function(){
            if(response.err_code === 0){

              var login = response.data;
              GS.setCurrentUser(login.sid, login.user);
              mainView.router.loadPage('index.html');
              SNSContacts.hidePreloader();
            }else{
              SNSContacts.hidePreloader();
              SNSContacts.alert(response.err_msg);
            }
          },500);

        });
      }
    }

  };

  return loginCtrl;
});