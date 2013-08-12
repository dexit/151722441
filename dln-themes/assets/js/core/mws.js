/*
 * MWS Admin v2.1 - Core JS
 * This file is part of MWS Admin, an Admin template build for sale at ThemeForest.
 * All copyright to this file is hold by Mairel Theafila <maimairel@yahoo.com> a.k.a nagaemas on ThemeForest.
 * Last Updated:
 * December 08, 2012
 *
 */
 
(function($) {
	$(document).ready(function() {	

		// Collapsible Panels
		$( '.dln-panel.dln-collapsible' ).each(function(i, element) {
			var p = $( element ),	
				header = p.find( '.dln-panel-header' );

			if( header && header.length) {
				var btn = $('<div class="dln-collapse-button dln-inset"><span></span></div>').appendTo(header);
				$('span', btn).on( 'click', function(e) {
					var p = $( this ).parents( '.dln-panel' );
					if( p.hasClass('dln-collapsed') ) {
						p.removeClass( 'dln-collapsed' )
							.children( '.dln-panel-inner-wrap' ).hide().slideDown( 250 );
					} else {
						p.children( '.dln-panel-inner-wrap' ).slideUp( 250, function() {
							p.addClass( 'dln-collapsed' );
						});
					}
					e.preventDefault();
				});
			}

			if( !p.children( '.dln-panel-inner-wrap' ).length ) {
				p.children( ':not(.dln-panel-header)' )
					.wrapAll( $('<div></div>').addClass( 'dln-panel-inner-wrap' ) );
			}
		})
	
		/* Side dropdown menu */
		$("div#dln-navigation ul li a, div#dln-navigation ul li span")
			.on('click', function(event) {
				if(!!$(this).next('ul').length) {
					$(this).next('ul').slideToggle('fast', function() {
						$(this).toggleClass('closed');
					});
					event.preventDefault();
				}
			});
		
		/* Responsive Layout Script */
		$("#dln-nav-collapse").on('click', function(e) {
			$( '#dln-navigation > ul' ).slideToggle( 'normal', function() {
				$(this).css('display', '').parent().toggleClass('toggled');
			});
			e.preventDefault();
		});
		
		/* Form Messages */
		$(".dln-form-message").on("click", function() {
			$(this).animate({ opacity:0 }, function() {
				$(this).slideUp("normal", function() {
					$(this).css("opacity", '');
				});
			});
		});

		// Checkable Tables
		$( 'table thead th.checkbox-column :checkbox' ).on('change', function() {
			var checked = $( this ).prop( 'checked' );
			$( this ).parents('table').children('tbody').each(function(i, tbody) {
				$(tbody).find('.checkbox-column').each(function(j, cb) {
					$( ':checkbox', $(cb) ).prop( "checked", checked ).trigger('change');
				});
			});
		});

		// Bootstrap Dropdown Workaround
		$(document).on('touchstart.dropdown.data-api', '.dropdown-menu', function (e) { e.stopPropagation() });
		
		/* File Input Styling */
		$.fn.fileInput && $("input[type='file']").fileInput();

		// Placeholders
		$.fn.placeholder && $('[placeholder]').placeholder();

		// Tooltips
		$.fn.tooltip && $('[rel="tooltip"]').tooltip();

		// Popovers
		$.fn.popover && $('[rel="popover"]').popover();
	});
}) (jQuery);