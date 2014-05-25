/**
 * Created by DinhLN on 5/25/2014.
 */
window.DLN = {};

DLN.noGeoSupport = function () {
    this.failMessage("Thiết bị của bạn không hỗ trợ GPS, xin vui lòng nâng cấp lên thiết bị khác để sử dụng!");
};

DLN.failMessage = function(message) {
    alert(message);
}