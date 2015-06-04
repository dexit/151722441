/**
 * Created by DinhLN on 28/4/2015.
 */

'use strict';

angular.module('aloPricesApp')
  .config(function ($translateProvider) {

    /* Translator locale object */
    var translator = {
      common: {
        save: 'Lưu',
        loading: 'Đang tải...',
        search: 'Tìm kiếm',
        cancel: 'Huỷ'
      },

      header: {
        title_exchanges: 'Tỷ giá',
        title_golds: 'Vàng',
        title_notifications: 'Thông báo',
        title_setting: 'Tùy chỉnh',
        title_exchange_add: 'Thêm tỷ giá',
        title_exchange_detail: 'Sơ đồ tỷ ',
        title_exchange_detail_list: 'Chi tiết tỷ giá',
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
        error_get_currency_detail: 'Không thể lấy danh sách tỷ giá!',
        error_register_notify: 'Không thể đăng ký thông báo.',
        error_get_device_notify: 'Không thể lấy thông tin về thông báo.'
      },

      exchanges: {
        share: 'Chia sẻ',
        exchange: {
          CURRENCY: 'Ngoại tệ',
          VCB: 'Ngoại tệ Vietcombank',
          GOLD: 'Vàng',
          SJC: 'Vàng SJC'
        },
        buy: 'Mua vào: ',
        sell: 'Bán ra: ',
        chart: 'Lược đồ'
      },

      exchange_add: {
        exchange_rates: 'Tỷ giá',
        golds: 'Vàng'
      },

      exchange_detail: {
        detail: 'Chi tiết',
        notification: 'Thông báo',
        exchange_rates: 'Tỷ giá',
        buy_min: 'Tỉ giá thấp nhất',
        buy_max: 'Tỉ giá cao nhất',
        notify_device: 'Thông báo qua thiết bị',
        buy: 'Mua vào',
        sell: 'Bán ra',
        goto_detail: 'Xem theo ngày'
      }
    };

    $translateProvider.translations('vi', translator);

  });
