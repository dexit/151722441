(function ($) {
    "use strict";

    var AdEdit = function () {
        this.$ad_id = parseInt($('#ad_id').val());
        this.$allow = true;
        this.$timer = null;
        this.$time_out = 2000;

        if (this.$ad_id) {
            this.init();
            this.initEvents();
            this.initPhoto();
            this.initModal();
        }
    };

    AdEdit.prototype.init = function () {
        var self = this;
    };

    AdEdit.prototype.initEvents = function () {
        var self = this;

        $('.ad-tabs .panel-default').on('click', function (e) {
            e.preventDefault();

            var selector = $(this).data('relate');
            if (selector) {
                $('.ad-form').addClass('hide');
                $('#' + selector).removeClass('hide');
                var hash = $(this).data('hash');
                if (hash) {
                    window.location.hash = '#' + hash;
                }
            }
        });

        var type = window.location.hash.substr(1);
        if (!type) {
            $('.ad-tabs .panel-default:first-child').trigger('click');
        } else {
            $('.ad-tabs .panel-default[data-hash="' + type + '"]').trigger('click');
        }

        /* For form desc */
        $('#ad_desc form').on('change', function (e) {
            self.checkFormDesc(true);
        });

        $('#dln_name').on({
            keydown: function (e) {
                var length = $(this).val().length;
                var count = 125 - length;
                if (count >= 0) {
                    $('#dln_name_count').text(count);
                } else {
                    $('#dln_name_count').text(0);
                }
            }
        });

        $('#dln_desc').on({
            keydown: function (e) {
                var length = $(this).val().length;
                var count = 500 - length;
                if (count >= 0) {
                    $('#dln_desc_count').text(count);
                } else {
                    $('#dln_desc_count').text(0);
                }
            }
        });

        $('#dln_price').on({
            change: function (e) {
                self.checkFormDesc(true);
            }
        });

        $('#dln_type input:radio, #dln_category_id').on('change', function (e) {
            self.checkFormDesc(true);
        });
    };

    AdEdit.prototype.checkCompleteAll = function () {
        var self = this;

        self.checkFormDesc(false);
        self.checkFormPhoto(false);
        self.checkFormSpace(false);
        self.checkFormLocation(false);
        self.checkFormProperty(false);
        self.calculatePercent(false);
    };

    AdEdit.prototype.calculatePercent = function () {
        var self = this;

        var percent = 0;
        $('.completed').each(function (e) {
            percent += $(this).data('percent');
        });
        if (percent >= 90) {
            $('#dln_active').addClass('btn-danger');
            $('#dln_active').removeClass('disabled');
        } else {
            $('#dln_active').addClass('disabled');
            $('#dln_active').removeClass('btn-danger');
        }
        percent += '%';
        $('#dln_progressbar').data('percentage', percent);
        $('#dln_progressbar').css('width', percent);
    };

    AdEdit.prototype.showChecked = function (selector) {
        $('div[data-relate="' + selector + '"]').addClass('completed');
        $('div[data-relate="' + selector + '"] .label-success').removeClass(
                'hide');
        $('div[data-relate="' + selector + '"] .label-default')
                .addClass('hide');
    };

    AdEdit.prototype.hideChecked = function (selector) {
        $('div[data-relate="' + selector + '"]').removeClass('completed');
        $('div[data-relate="' + selector + '"] .label-success')
                .addClass('hide');
        $('div[data-relate="' + selector + '"] .label-default').removeClass(
                'hide');
    };

    AdEdit.prototype.showStatus = function (no_loading) {
        $('.dln-status').removeClass('text-danger');
        $('.dln-status').addClass('text-success');
        $('.dln-status').addClass('in');
        $('.dln-status').text('Đang lưu...');
        if (!no_loading) {
            $('.dln-loading').addClass('show');
        }
    };

    AdEdit.prototype.hideStatus = function (no_loading) {
        $('.dln-status').removeClass('in');
        $('.dln-status').text('Đã lưu!');
        if (!no_loading) {
            $('.dln-loading').removeClass('show');
        }
    };

    AdEdit.prototype.errorStatus = function (no_loading) {
        $('.dln-status').addClass('text-danger');
        $('.dln-status').removeClass('in');
        $('.dln-status').text('Lỗi!');
        if (!no_loading) {
            $('.dln-loading').removeClass('show');
        }
    };

    AdEdit.prototype.checkFormDesc = function (calc) {
        var self = this;

        var form = $('#ad_desc form');

        form.validate({
            errorPlacement: function (error, element) {
            }
        });

        if (self.$ad_id && self.$allow && form.valid()) {
            if (calc) {
                /* save form desc */
                self.saveAdCommon();
            } else {
                self.showChecked('ad_desc');
            }
            return true;
        } else {
            self.hideChecked('dln_desc');
            return false;
        }
    };

    AdEdit.prototype.checkFormPhoto = function (calc) {
        var self = this;

        var form = $('#ad_photo form');

        if (calc) {
            form.validate();
        } else {
            form.validate({
                errorPlacement: function (error, element) {
                }
            });
        }

        if (form.valid()) {
            self.showChecked('ad_photo');
            if (calc) {
                self.calculatePercent();
            }
            return true;
        }
        return false;
    };

    AdEdit.prototype.checkFormSpace = function (calc) {
        var self = this;

        var form = $('#ad_space form');

        if (calc) {
            form.validate();
        } else {
            form.validate({
                errorPlacement: function (error, element) {
                }
            });
        }

        if (self.$ad_id && self.$allow && form.valid()) {
            if (calc) {
                /* save form desc */
                self.showStatus(false);
                self.$allow = false;
                $.ajax({
                    type: 'PUT',
                    url: window.root_url_api + '/ad/' + self.$ad_id + '/infor',
                    data: form.serialize(),
                    success: function (res) {
                        self.$allow = true;
                        if (res.status == 'success') {
                            self.showChecked('ad_desc');
                            self.hideStatus(false);
                            self.calculatePercent();
                        }
                    },
                    error: function (data) {
                        self.$allow = true;
                        self.errorStatus(false);
                        self.hideChecked('dln_desc');
                        if (data.responseText) {
                            window.ad_common.showError(data.responseText);
                        } else {
                            console.log(data);
                        }
                    }
                });
            } else {
                self.showChecked('ad_desc');
            }
            return true;
        } else {
            self.hideChecked('dln_desc');
            return false;
        }
    };

    AdEdit.prototype.checkFormLocation = function (calc) {
        var self = this;

        var form = $('#ad_location form');

        if (calc) {
            form.validate();
        } else {
            form.validate({
                errorPlacement: function (error, element) {
                }
            });
        }

        if (form.valid()) {
            self.showChecked('ad_location');
            if (calc) {
                /* save form location */
                self.saveAdCommon();
            }
            return true;
        }
        return false;
    };

    AdEdit.prototype.checkFormProperty = function (calc) {
        var self = this;

        var form = $('#ad_property form');

        if (calc) {
            form.validate();
        } else {
            form.validate({
                errorPlacement: function (error, element) {
                }
            });
        }

        if (form.valid()) {
            self.showChecked('ad_property');
            if (calc) {
                /* save form property */
                self.saveAdCommon();
            }
            return true;
        }
        return false;
    };

    AdEdit.prototype.saveAdCommon = function (form) {
        var self = this;

        self.showStatus(false);
        self.$allow = false;
        $.ajax({
            type: 'PUT',
            url: window.root_url_api + '/ad/' + self.$ad_id,
            data: form.serialize(),
            success: function (res) {
                self.$allow = true;
                if (res.status == 'success') {
                    self.showChecked('ad_desc');
                    self.hideStatus(false);
                    self.calculatePercent();
                }
            },
            error: function (data) {
                self.$allow = true;
                self.errorStatus(false);
                self.hideChecked('dln_desc');
                if (data.responseText) {
                    window.ad_common.showError(data.responseText);
                } else {
                    console.log(data);
                }
            }
        });
    };

    /**
     * Function create thumb ad image after upload
     */
    AdEdit.prototype.initPhoto = function () {
        var self = this;

        $('#dln_photo_upload').on('click', function (e) {
            e.preventDefault();
            $('#dln_file_upload').trigger('click');
        });
        if (self.$ad_id) {
            $('#dln_file_upload').fileupload({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                url: window.root_url_api + '/ad/' + self.$ad_id + '/upload',
                paramName: 'file_data',
                send: function (e, data) {
                    self.$allow = false;
                    self.showStatus(true);
                },
                done: function (e, data) {
                    self.$allow = true;
                    self.hideStatus(true);

                    if (data.result.code == 200) {
                        self.createPhotoAd(data.result);
                    }
                },
                error: function (data) {
                    self.$allow = true;
                    self.errorStatus(true);

                    if (data.responseText) {
                        window.ad_common.showError(data.responseText);
                    } else {
                        console.log(data);
                    }
                }
            });
            self.setPhotoFeature();
        }
    };

    AdEdit.prototype.createPhotoAd = function (response) {
        if (!response)
            return false;
        var self = this;

        var html = response.data.photo_pattern;
        $('.dln_photos').append(html);
        var selector = '#dln_photo_item_' + response.data.id;
        self.initPhotoEvents();
        self.setPhotoFeature();
    };

    AdEdit.prototype.savePhotoOrder = function () {
        var self = this;

        if (!self.$ad_id) {
            return false;
        }

        clearTimeout(self.$timer);
        self.$timer = setTimeout(function () {
            self.showStatus(true);

            var photo_ids = [];
            $('#dln_photos .dln-photo-item').each(function () {
                photo_ids.push($(this).data('id'));
            });

            self.$allow = false;
            $.ajax({
                type: 'POST',
                url: window.root_url_api + 'ad/' + self.$ad_id + '/photo_order',
                data: {
                    photo_ids: photo_ids
                },
                success: function (res) {
                    self.$allow = true;
                    self.hideStatus(true);

                    if (res.status == 'success') {
                        self.setPhotoFeature();
                    }
                },
                error: function (data) {
                    self.$allow = true;
                    self.errorStatus(true);

                    if (data.responseText) {
                        window.ad_common.showError(data.responseText);
                    } else {
                        console.log(data);
                    }
                }
            });
        }, self.$time_out);
    };

    AdEdit.prototype.setPhotoFeature = function () {
        $('#dln_photos .dln-photo-item').addClass('bg-master-lightest');
        $('#dln_photos .dln-photo-item:first-child').removeClass('bg-master-lightest');
        $('#dln_photos .dln-photo-item:first-child').addClass('bg-master-lightest');
    };

    AdEdit.prototype.initPhotoEvents = function (id, selector) {
        var self = this;
        var id = intval(id);

        if (!id) {
            return false;
        }

        $(selector + ' #dln_photo_desc').on('change', function (e) {
            if (!self.$ad_id) {
                return false;
            }

            var desc = $.trim($(this).text());

            if (self.$allow && desc) {
                self.showStatus(false);

                self.$allow = false;
                $.ajax({
                    type: 'PUT',
                    url: window.root_url_api + 'ad/' + self.$ad_id + '/photo/' + id,
                    data: {
                        desc: desc
                    },
                    success: function (res) {
                        self.$allow = true;
                        self.hideStatus(false);
                    },
                    error: function (data) {
                        self.$allow = true;
                        self.errorStatus(false);
                        if (data.responseText) {
                            window.ad_common.showError(data.responseText);
                        } else {
                            console.log(data);
                        }
                    }
                });
            }
        });

        /* For delete button*/
        $(selector + ' .dln-delete-photo').on('click', function (e) {
            if (!self.$ad_id) {
                return false;
            }

            var result = confirm("Bạn muốn xóa ảnh này?");

            if (self.$allow && result) {
                self.showStatus(false);

                self.$allow = false;
                $.ajax({
                    type: 'DELETE',
                    url: window.root_url_api + 'ad/' + self.$ad_id + '/photo/' + id,
                    success: function (res) {
                        self.$allow = true;
                        if (res.status == 'success') {
                            self.hideStatus(false);
                            $(selector).remove();
                        }
                    },
                    error: function (data) {
                        self.$allow = true;
                        self.errorStatus(false);
                        if (data.responseText) {
                            window.ad_common.showError(data.responseText);
                        } else {
                            console.log(data);
                        }
                    }
                });
            }
        });

        /* For order up photo */
        $(selector + ' .dln-up-photo').on('click', function (e) {
            var item = $(this).parents('.dln-photo-item');
            var prev = item.prev();
            if (prev.length == 0)
                return;
            prev.css('z-index', 999).css('position', 'relative').animate({
                top: item.height()
            }, 250);
            item.css('z-index', 1000).css('position', 'relative').animate({
                top: '-' + prev.height()
            }, 300, function () {
                prev.css('z-index', '').css('top', '').css('position', '');
                item.css('z-index', '').css('top', '').css('position', '');
                item.insertBefore(prev);

                self.savePhotoOrder();
            });
        });

        /* For order down photo */
        $(selector + ' .dln-down-photo').on('click', function (e) {
            var item = $(this).parents('.dln-photo-item');
            var next = item.next();
            if (next.length == 0)
                return;
            next.css('z-index', 999).css('position', 'relative').animate({
                top: '-' + item.height()
            }, 250);
            item.css('z-index', 1000).css('position', 'relative').animate({
                top: next.height()
            }, 300, function () {
                next.css('z-index', '').css('top', '').css('position', '');
                item.css('z-index', '').css('top', '').css('position', '');
                item.insertAfter(next);

                self.savePhotoOrder();
            });
        });
    };

    AdEdit.prototype.initModal = function () {
        var self = this;

        // On close modal
        $('#dln_modal').on('hide.bs.modal', function (e) {
            $('#dln_modal .dln-body').html('');
        });

        $('.dln-modal').on('click', function (e) {
            e.preventDefault();

            var type = $(this).data('type');
            if (!type) {
                return false;
            }
            var url = window.root_url + '/modal?type=' + $(this).data('type');
            var options = $(this).data('options');
            var header = $(this).data('header');
            var relate = $(this).data('relate');
            if (relate) {
                url += '&values=' + $('#' + relate).val();
            }

            self.showModal();
            self.showModalLoading();
            $('#dln_modal .modal-header h5').text('');

            // Send ajax request for get html content
            $.ajax({
                type: 'POST',
                url: url,
                data: options,
                success: function (response) {
                    self.hideModalLoading();
                    $('#dln_modal .modal-header h5').text(header);
                    $('#dln_modal .dln-body').html(response);
                },
            });
        });
    };

    AdDetail.prototype.initModalSave = function () {
        var self = this;

        $('#dln_modal_save').on('click', function (e) {
            e.preventDefault();

            self.$helper.hideModal();
        });
    };

    AdEdit.prototype.showModal = function () {
        // Show modal with loading indicator
        $('#dln_modal').modal('show');
    };

    AdEdit.prototype.hideModal = function () {
        // Show modal with loading indicator
        $('#dln_modal').modal('hide');
    };

    AdEdit.prototype.hideModalLoading = function () {
        $('#dln_modal .dln-loading').removeClass('show');
    };

    AdEdit.prototype.showModalLoading = function () {
        $('#dln_modal .dln-loading').addClass('show');
    };

    $(document).ready(function () {
        var ad_edit = new AdEdit();

        // Masked inputs initialization
        $.fn.inputmask && $('[data-toggle="masked"]').inputmask();
    });

}(window.jQuery));
