(function($) {
	"use strict";

	var AdEdit = function() {
		this.$ad_id = $('#ad_id').val();
		this.$allow = false;

		if (this.$ad_id) {
			this.init();
			this.initEvents();
		}
	};

	AdEdit.prototype.init = function() {
		var self = this;
	};

	AdEdit.prototype.initEvents = function() {
		var self = this;

		$('.ad-tabs .panel-default').on('click', function(e) {
			e.preventDefault();

			var selector = $(this).data('relate');
			if (selector) {
				$('.ad-form').addClass('hide');
				$('#' + selector).removeClass('hide');
			}
		});

		/* For form desc */
		$('#ad_desc form').on('change', function (e) {
			self.$allow = true;
			console.log(self.$allow);
		});
		$('#dln_name').on({
			keydown : function(e) {
				var length = $(this).val().length;
				var count = 125 - length;
				if (count >= 0) {
					$('#dln_name_count').text(count);
				} else {
					$('#dln_name_count').text(0);
				}
			},
			blur : function(e) {
				self.checkFormDesc(true);
			}
		});

		$('#dln_desc').on({
			keydown : function(e) {
				var length = $(this).val().length;
				var count = 500 - length;
				if (count >= 0) {
					$('#dln_desc_count').text(count);
				} else {
					$('#dln_desc_count').text(0);
				}
			},
			blur : function(e) {
				self.checkFormDesc(true);
			}
		});

		$('#dln_price').on({
			blur : function(e) {
				self.checkFormDesc(true);
			}
		});

		$('#dln_type input:radio, #dln_category_id').on('change', function(e) {
			self.checkFormDesc(true);
		});

		/* For form photo */
		$('.dln-file-wrapper button').on('click', function(e) {
			e.preventDefault();
			$('.dln-file-upload').trigger('click');
		});
		if (self.$ad_id) {
			$('.dln-file-upload').fileupload({
				// Uncomment the following to send cross-domain cookies:
				//xhrFields: {withCredentials: true},
				url : window.root_url_api + '/ad/' + self.$ad_id + '/upload',
				paramName : 'file_data',
				done : function(e, data) {
					if (data.result.code == 200) {
						self.createPhotoAd(data.result);
					}
				}
			});
		}

		$('#dln_save_photo_order').on('click', function(e) {
			e.preventDefault();

			var photo_ids = [];
			$('.dln-photo-placeholder').each(function() {
				var photo_id = $(this).data('id');
				if (photo_id) {
					photo_ids.push(photo_id);
				}
			});

			if (photo_ids.length) {
				photo_ids = photo_ids.split(',');
				self.showStatus();
				$.ajax({
					type : 'POST',
					url : window.root_url_api + '/photo/order',
					data : {
						photo_ids : photo_ids
					},
					success : function(res) {
						self.$allow = false;
						if (res.status == 'success') {
							self.hideStatus();
						}
					},
					error : function(data) {
						self.$allow = false;
						self.errorStatus();
						self.hideChecked('dln_photo');
						if (data.responseText) {
							alert(data.responseText);
						} else {
							console.log(data);
						}
					}
				});
			}

		});
	};

	AdEdit.prototype.checkCompleteAll = function() {
		var self = this;

		self.checkFormDesc(false);
		self.checkFormPhoto(false);
		self.checkFormSpace(false);
		self.checkFormLocation(false);
		self.checkFormProperty(false);
		self.calculatePercent(false);
	};

	AdEdit.prototype.calculatePercent = function() {
		var self = this;

		var percent = 0;
		$('.completed').each(function(e) {
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

	AdEdit.prototype.showChecked = function(selector) {
		$('div[data-relate="' + selector + '"]').addClass('completed');
		$('div[data-relate="' + selector + '"] .label-success').removeClass(
				'hide');
		$('div[data-relate="' + selector + '"] .label-default')
				.addClass('hide');
	};

	AdEdit.prototype.hideChecked = function(selector) {
		$('div[data-relate="' + selector + '"]').removeClass('completed');
		$('div[data-relate="' + selector + '"] .label-success')
				.addClass('hide');
		$('div[data-relate="' + selector + '"] .label-default').removeClass(
				'hide');
	};

	AdEdit.prototype.showStatus = function() {
		$('.dln-status').removeClass('text-danger');
		$('.dln-status').addClass('text-success');
		$('.dln-status').addClass('in');
		$('.dln-status').text('Đang lưu');
		$('.dln-loading').addClass('show');
	};

	AdEdit.prototype.hideStatus = function() {
		$('.dln-status').removeClass('in');
		$('.dln-status').text('Đã lưu!');
		$('.dln-loading').removeClass('show');
	};

	AdEdit.prototype.errorStatus = function() {
		$('.dln-status').addClass('text-danger');
		$('.dln-status').removeClass('in');
		$('.dln-status').text('Lỗi!');
		$('.dln-loading').removeClass('show');
	};

	AdEdit.prototype.checkFormDesc = function(calc) {
		var self = this;

		var form = $('#ad_desc form');

		if (calc) {
			form.validate();
		} else {
			form.validate({
				errorPlacement : function(error, element) {
				}
			});
		}
		
		if (self.$allow && form.valid()) {
			if (calc) {
				/* save form desc */
				if (self.$ad_id) {
					self.showStatus();
					$.ajax({
						type : 'PUT',
						url : window.root_url_api + '/ad/' + self.$ad_id,
						data : form.serialize(),
						success : function(res) {
							self.$allow = false;
							if (res.status == 'success') {
								self.showChecked('ad_desc');
								self.hideStatus();
								self.calculatePercent();
							}
						},
						error : function(data) {
							self.$allow = false;
							self.errorStatus();
							self.hideChecked('dln_desc');
							if (data.responseText) {
								var response = JSON.parse(data.responseText);
								$('body').pgNotification({
				                    message: response.message,
				                    type: 'danger'
				                }).show();
							} else {
								console.log(data);
							}
						}
					});
				}
			} else {
				self.showChecked('ad_desc');
			}
			return true;
		} else {
			self.hideChecked('dln_desc');
			return false;
		}
	};

	AdEdit.prototype.checkFormPhoto = function(calc) {
		var self = this;

		var form = $('#ad_photo form');

		if (calc) {
			form.validate();
		} else {
			form.validate({
				errorPlacement : function(error, element) {
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

	AdEdit.prototype.checkFormSpace = function(calc) {
		var self = this;

		var form = $('#ad_space form');

		if (calc) {
			form.validate();
		} else {
			form.validate({
				errorPlacement : function(error, element) {
				}
			});
		}

		if (form.valid()) {
			self.showChecked('ad_space');
			if (calc) {
				self.calculatePercent();
			}
			return true;
		}
		return false;
	};

	AdEdit.prototype.checkFormLocation = function(calc) {
		var self = this;

		var form = $('#ad_location form');

		if (calc) {
			form.validate();
		} else {
			form.validate({
				errorPlacement : function(error, element) {
				}
			});
		}

		if (form.valid()) {
			self.showChecked('ad_location');
			if (calc) {
				self.calculatePercent();
			}
			return true;
		}
		return false;
	};

	AdEdit.prototype.checkFormProperty = function(calc) {
		var self = this;

		var form = $('#ad_property form');

		if (calc) {
			form.validate();
		} else {
			form.validate({
				errorPlacement : function(error, element) {
				}
			});
		}

		if (form.valid()) {
			self.showChecked('ad_property');
			if (calc) {
				self.calculatePercent();
			}
			return true;
		}
		return false;
	};

	/**
	 * Function create thumb ad image after upload
	 */
	AdEdit.prototype.createPhotoAd = function(response) {
		if (!response)
			return false;
		var self = this;

		var html = response.data.photo_pattern;
		html = html.replace('__SRC__', response.data.thumb);
		$('.dln-photos-wrapper').append(html);
	};

	$(document).ready(function() {
		var ad_edit = new AdEdit();
		
		// Masked inputs initialization
	    $.fn.inputmask && $('[data-toggle="masked"]').inputmask();
	    
	    // Initialize select2
	    $.fn.select2 && $('[data-init-plugin="select2"]').each(function() {
            $(this).select2({
                minimumResultsForSearch: "true" == $(this).attr("data-disable-search") ? -1 : 1
            }).on("select2-opening", function() {
                $.fn.scrollbar && $(".select2-results").scrollbar({
                    ignoreMobile: !1
                })
            })
        });
        
        $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
	});

}(window.jQuery));
