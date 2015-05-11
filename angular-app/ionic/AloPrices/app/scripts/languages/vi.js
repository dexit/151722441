/**
 * Created by DinhLN on 28/4/2015.
 */

angular.module('aloPricesApp')
  .config(function ($translateProvider) {

    /* Translator locale object */
    var translator = {
      common: {
        save: 'Lưu'
      },

      header: {
        title_home: 'Tỷ giá',
        title_notifications: 'Thông báo',
        title_setting: 'Tùy chỉnh',
        title_exchange_add: 'Thêm tỷ giá',
        title_facebook: 'Tài khoản Facebook'
      },

      setting: {
        notify: 'Thông báo',
        facebook: 'Facebook',
        about: 'Tác giả',
        exit: 'Thoát'
      },

      message: {
        error_get_device: 'Không thể đăng ký thiết bị!'
      },

      home: {
        share: 'Chia sẻ',
        exchange: 'Tỷ giá',
        chart: 'Lược đồ'
      },

      exchange_add: {
        external: 'Ngoại tệ',
        internal: 'Trong nước'
      }
    };

    $translateProvider.translations('vi', translator);

  });
