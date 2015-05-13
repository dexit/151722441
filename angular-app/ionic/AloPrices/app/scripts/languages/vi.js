/**
 * Created by DinhLN on 28/4/2015.
 */

angular.module('aloPricesApp')
  .config(function ($translateProvider) {

    /* Translator locale object */
    var translator = {
      common: {
        save: 'Lưu',
        loading: 'Đang tải...'
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
        error_get_device: 'Không thể đăng ký thiết bị!',
        error_get_currency_detail: 'Không thể lấy danh sách tỷ giá!'
      },

      home: {
        share: 'Chia sẻ',
        exchange: 'Tỷ giá',
        chart: 'Lược đồ'
      },

      exchange_add: {
        exchange_rates: 'Tỷ giá',
        golds: 'Vàng'
      }
    };

    $translateProvider.translations('vi', translator);

  });
