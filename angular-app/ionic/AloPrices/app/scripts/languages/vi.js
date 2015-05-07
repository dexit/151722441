/**
 * Created by DinhLN on 28/4/2015.
 */

angular.module('aloPricesApp')
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
      },

      message: {
        error_get_device: 'Không thể đăng ký thiết bị!'
      }
    };

    $translateProvider.translations('vi', translator);

  });