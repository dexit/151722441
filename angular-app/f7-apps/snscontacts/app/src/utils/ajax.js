/**
 * Created by DinhLN on 26/4/2015.
 */
define(['appFunc',
  'i18n!nls/lang',
  'components/networkStatus'],function(appFunc, i18n, networkStatus) {
  'use strict';

  var ajax = {

    /**
     * Search error by error_code.
     *
     * @param code
     * @param array
     * @returns {*}
     */
    search: function(code, array){
      for (var i=0;i< array.length; i++){
        if (array[i].code === code) {
          return array[i];
        }
      }
      return false;
    },

    /**
     * Prepare for url request
     *
     * @param options
     * @returns {string}
     */
    getRequestURL: function(options){
      //var host = apiServerHost || window.location.host;
      //var port = options.port || window.location.port;
      var query = options.query || {};
      var func = options.func || '';

      var apiServer = 'api/v1/' + func +
        (appFunc.isEmpty(query) ? '' : '?');

      var name;
      for (name in query) {
        apiServer += name + '=' + query[name] + '&';
      }

      return apiServer.replace(/&$/gi, '');
    },

    /**
     * For ajax simple call.
     *
     * @param options
     * @param callback
     * @returns {boolean}
     */
    simpleCall: function(options, callback){
      options = options || {};
      options.data = options.data ? options.data : '';

      options.method = options.method || 'GET';

      if(appFunc.isPhonegap()){
        /* Check network connection */
        var network = networkStatus.checkConnection();
        if(network === 'NoNetwork'){

          SNSContacts.alert(i18n.error.no_network, function(){
            SNSContacts.hideIndicator();
            SNSContacts.hidePreloader();
          });

          return false;
        }
      }

      /* Send ajax request */
      $$.ajax({
        url: ajax.getRequestURL(options) ,
        method: options.method,
        data: options.data,
        success:function(data){
          data = data ? JSON.parse(data) : '';

          var codes = [
            {code:10000, message:'Phiên làm việc của bạn đã hết hạn, xin vui lòng đăng nhập lại', path:'/'},
            {code:10001, message:'Không xác định lỗi, xin vui lòng đăng nhập lại', path:'tpl/login.html'},
            {code:20001, message:'Tài khoản và mật khẩu không chính xác', path:'/'}
          ];

          var codeLevel = ajax.search(data.err_code, codes);

          if(!codeLevel){

            (typeof(callback) === 'function') ? callback(data) : '';

          }else{

            SNSContacts.alert(codeLevel.message,function(){
              if(codeLevel.path !== '/')
                mainView.router.loadPage(codeLevel.path);

              SNSContacts.hideIndicator();
              SNSContacts.hidePreloader();
            });
          }
        }
      });

    }

  };

  return ajax;
});
