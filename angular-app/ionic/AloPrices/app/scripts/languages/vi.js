/**
 * Created by DinhLN on 28/4/2015.
 */

angular.module('AloPrices')
  .config(function ($translateProvider) {

    /* Translator locale object */
    var translator = {
      header: {
        title_home: 'Tỷ giá',
        title_notifications: 'Thông báo',
        title_setting: 'Khác'
      },

      setting: {
        notify: 'Thông báo',
        about: 'Tác giả',
        exit: 'Thoát'
      }
    };

    $translateProvider.translations('vi', translator);

  });