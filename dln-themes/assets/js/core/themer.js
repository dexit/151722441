/*
 * MWS Admin v2.1 - Themer JS
 * This file is part of MWS Admin, an Admin template build for sale at ThemeForest.
 * All copyright to this file is hold by Mairel Theafila <maimairel@yahoo.com> a.k.a nagaemas on ThemeForest.
 * Last Updated:
 * December 08, 2012
 *
 */
 
(function($) {
	$(document).ready(function() {
		var backgroundPattern = dln_var.site_url + "images/core/bg/paper.png";
		var baseColor = "#35353a";
		var highlightColor = "#c5d52b";
		var textColor = "#c5d52b";
		var textGlowColor = {r: 197, g: 213, b: 42, a: 0.5};
		
		var patterns = [
			{
				name: "Paper", 
				img: dln_var.site_url + "images/core/bg/paper.png"
			}, {
				name: "Blueprint", 
				img: dln_var.site_url + "images/core/bg/blueprint.png"
			}, {
				name: "Bricks", 
				img: dln_var.site_url + "images/core/bg/bricks.png"
			}, {
				name: "Carbon", 
				img: dln_var.site_url + "images/core/bg/carbon.png"
			}, {
				name: "Circuit", 
				img: dln_var.site_url + "images/core/bg/circuit.png"
			}, {
				name: "Holes", 
				img: dln_var.site_url + "images/core/bg/holes.png"
			}, {
				name: "Mozaic", 
				img: dln_var.site_url + "images/core/bg/mozaic.png"
			}, {
				name: "Roof", 
				img: dln_var.site_url + "images/core/bg/roof.png"
			}, {
				name: "Stripes", 
				img: dln_var.site_url + "images/core/bg/stripes.png"
			}, {
				name: "Arches", 
				img: dln_var.site_url + "images/core/bg/arches.png"
			}, {
				name: "Bright Squares", 
				img: dln_var.site_url + "images/core/bg/bright_squares.png"
			}, {
				name: "Brushed Alu", 
				img: dln_var.site_url + "images/core/bg/brushed_alu.png"
			}, {
				name: "Circles", 
				img: dln_var.site_url + "images/core/bg/circles.png"
			}, {
				name: "Climpek", 
				img: dln_var.site_url + "images/core/bg/climpek.png"
			}, {
				name: "Connect", 
				img: dln_var.site_url + "images/core/bg/connect.png"
			}, {
				name: "Corrugation", 
				img: dln_var.site_url + "images/core/bg/corrugation.png"
			}, {
				name: "Cubes", 
				img: dln_var.site_url + "images/core/bg/cubes.png"
			}, {
				name: "Diagonal Noise", 
				img: dln_var.site_url + "images/core/bg/diagonal-noise.png"
			}, {
				name: "Diagonal Striped Brick", 
				img: dln_var.site_url + "images/core/bg/diagonal_striped_brick.png"
			}, {
				name: "Diamonds", 
				img: dln_var.site_url + "images/core/bg/diamonds.png"
			}, {
				name: "Diamond Upholstery", 
				img: dln_var.site_url + "images/core/bg/diamond_upholstery.png"
			}, {
				name: "Escheresque", 
				img: dln_var.site_url + "images/core/bg/escheresque.png"
			}, {
				name: "Fabric Plaid", 
				img: dln_var.site_url + "images/core/bg/fabric_plaid.png"
			}, {
				name: "Furley", 
				img: dln_var.site_url + "images/core/bg/furley_bg.png"
			}, {
				name: "Gplaypattern", 
				img: dln_var.site_url + "images/core/bg/gplaypattern.png"
			}, {
				name: "Gradient Squares", 
				img: dln_var.site_url + "images/core/bg/gradient_squares.png"
			}, {
				name: "Grey", 
				img: dln_var.site_url + "images/core/bg/grey.png"
			}, {
				name: "Grilled", 
				img: dln_var.site_url + "images/core/bg/grilled.png"
			}, {
				name: "Hexellence", 
				img: dln_var.site_url + "images/core/bg/hexellence.png"
			}, {
				name: "Lghtmesh", 
				img: dln_var.site_url + "images/core/bg/lghtmesh.png"
			}, {
				name: "Light Alu", 
				img: dln_var.site_url + "images/core/bg/light_alu.png"
			}, {
				name: "Light Checkered Tiles", 
				img: dln_var.site_url + "images/core/bg/light_checkered_tiles.png"
			}, {
				name: "Light Honeycomb", 
				img: dln_var.site_url + "images/core/bg/light_honeycomb.png"
			}, {
				name: "Littleknobs", 
				img: dln_var.site_url + "images/core/bg/littleknobs.png"
			}, {
				name: "Nistri", 
				img: dln_var.site_url + "images/core/bg/nistri.png"
			}, {
				name: "Noise Lines", 
				img: dln_var.site_url + "images/core/bg/noise_lines.png"
			}, {
				name: "Noise Pattern", 
				img: dln_var.site_url + "images/core/bg/noise_pattern_with_crosslines.png"
			}, {
				name: "Noisy Grid", 
				img: dln_var.site_url + "images/core/bg/noisy_grid.png"
			}, {
				name: "Norwegian Rose", 
				img: dln_var.site_url + "images/core/bg/norwegian_rose.png"
			}, {
				name: "Pineapplecut", 
				img: dln_var.site_url + "images/core/bg/pineapplecut.png"
			}, {
				name: "Pinstripe", 
				img: dln_var.site_url + "images/core/bg/pinstripe.png"
			}, {
				name: "Project Papper", 
				img: dln_var.site_url + "images/core/bg/project_papper.png"
			}, {
				name: "Ravenna", 
				img: dln_var.site_url + "images/core/bg/ravenna.png"
			}, {
				name: "Reticular Tissue", 
				img: dln_var.site_url + "images/core/bg/reticular_tissue.png"
			}, {
				name: "Rockywall", 
				img: dln_var.site_url + "images/core/bg/rockywall.png"
			}, {
				name: "Roughcloth", 
				img: dln_var.site_url + "images/core/bg/roughcloth.png"
			}, {
				name: "Shattered", 
				img: dln_var.site_url + "images/core/bg/shattered.png"
			}, {
				name: "Silver Scales", 
				img: dln_var.site_url + "images/core/bg/silver_scales.png"
			}, {
				name: "Skelatal Weave", 
				img: dln_var.site_url + "images/core/bg/skelatal_weave.png"
			}, {
				name: "Small Crackle Bright", 
				img: dln_var.site_url + "images/core/bg/small-crackle-bright.png"
			}, {
				name: "Small Tiles", 
				img: dln_var.site_url + "images/core/bg/small_tiles.png"
			}, {
				name: "Square", 
				img: dln_var.site_url + "images/core/bg/square_bg.png"
			}, {
				name: "Struckaxiom", 
				img: dln_var.site_url + "images/core/bg/struckaxiom.png"
			}, {
				name: "Subtle Stripes", 
				img: dln_var.site_url + "images/core/bg/subtle_stripes.png"
			}, {
				name: "Vichy", 
				img: dln_var.site_url + "images/core/bg/vichy.png"
			}, {
				name: "Washi", 
				img: dln_var.site_url + "images/core/bg/washi.png"
			}, {
				name: "Wavecut", 
				img: dln_var.site_url + "images/core/bg/wavecut.png"
			}, {
				name: "Weave", 
				img: dln_var.site_url + "images/core/bg/weave.png"
			}, {
				name: "Whitey", 
				img: dln_var.site_url + "images/core/bg/whitey.png"
			}, {
				name: "White Brick Wall", 
				img: dln_var.site_url + "images/core/bg/white_brick_wall.png"
			}, {
				name: "White Tiles", 
				img: dln_var.site_url + "images/core/bg/white_tiles.png"
			}, {
				name: "Worn Dots", 
				img: dln_var.site_url + "images/core/bg/worn_dots.png"
			}
		];
		
		var presets = [
			{
				name: "Default", 
				baseColor: "35353a", 
				highlightColor: "c5d52b", 
				textColor: "c5d52b", 
				textGlowColor: {r: 197, g: 213, b: 42, a: 0.5}
			}, {
				name: "Army", 
				baseColor: "363d1b", 
				highlightColor: "947131", 
				textColor: "ffb575", 
				textGlowColor: {r: 237, g: 255, b: 41, a: 0.4}
			}, {
				name: "Rocky Mountains", 
				baseColor: "2f2f33", 
				highlightColor: "808080", 
				textColor: "b0e6ff", 
				textGlowColor: {r: 230, g: 232, b: 208, a: 0.4}
			}, {
				name: "Chinese Temple", 
				baseColor: "4f1b1b", 
				highlightColor: "e8cb10", 
				textColor: "f7ff00", 
				textGlowColor: {r: 255, g: 255, b: 0, a: 0.6}
			}, {
				name: "Boutique", 
				baseColor: "292828", 
				highlightColor: "f08dcc", 
				textColor: "fcaee3", 
				textGlowColor: {r: 186, g: 9, b: 230, a: 0.5}
			}, {
				name: "Toxic", 
				baseColor: "42184a", 
				highlightColor: "97c730", 
				textColor: "b1ff4c", 
				textGlowColor: {r: 230, g: 232, b: 208, a: 0.45}
			}, {
				name: "Aquamarine", 
				baseColor: "192a54", 
				highlightColor: "88a9eb", 
				textColor: "8affe2", 
				textGlowColor: {r: 157, g: 224, b: 245, a: 0.5}
			}
		];
		
		var backgroundTargets = 
		[
			"body", 
			"#dln-container"
		];
		
		var baseColorTargets = 
		[
			"#dln-sidebar", 
			"#dln-sidebar-bg", 
			"#dln-header", 
			".dln-panel .dln-panel-header", 
			"#dln-login", 
			"#dln-login .dln-login-lock", 
			".ui-accordion .ui-accordion-header", 
			".ui-tabs .ui-tabs-nav", 
			".ui-datepicker", 
			".fc-event-skin", 
			".ui-dialog .ui-dialog-titlebar", 
			".jGrowl .jGrowl-notification, .jGrowl .jGrowl-closer", 
			"#dln-user-tools .dln-dropdown-menu .dln-dropdown-box", 
			"#dln-user-tools .dln-dropdown-menu.open .dln-dropdown-trigger"
		];
		
		var borderColorTargets = 
		[
			"#dln-header"
		];
		
		var highlightColorTargets = 
		[
			"#dln-searchbox .dln-search-submit", 
			".dln-panel .dln-panel-header .dln-collapse-button span", 
			".dataTables_wrapper .dataTables_paginate .paginate_disabled_previous", 
			".dataTables_wrapper .dataTables_paginate .paginate_enabled_previous", 
			".dataTables_wrapper .dataTables_paginate .paginate_disabled_next", 
			".dataTables_wrapper .dataTables_paginate .paginate_enabled_next", 
			".dataTables_wrapper .dataTables_paginate .paginate_active", 
			".dln-table tbody tr.odd:hover td", 
			".dln-table tbody tr.even:hover td", 
			".ui-slider-horizontal .ui-slider-range", 
			".ui-slider-vertical .ui-slider-range", 
			".ui-progressbar .ui-progressbar-value", 
			".ui-datepicker td.ui-datepicker-current-day", 
			".ui-datepicker .ui-datepicker-prev", 
			".ui-datepicker .ui-datepicker-next", 
			".ui-accordion-header .ui-accordion-header-icon", 
			".ui-dialog-titlebar-close"
		];
		
		var textTargets = 
		[
			".dln-panel .dln-panel-header span", 
			"#dln-navigation ul li.active a", 
			"#dln-navigation ul li.active span", 
			"#dln-user-tools #dln-username", 
			"#dln-navigation ul li .dln-nav-tooltip", 
			"#dln-user-tools #dln-user-info #dln-user-functions #dln-username", 
			".ui-dialog .ui-dialog-title", 
			".ui-state-default", 
			".ui-state-active", 
			".ui-state-hover", 
			".ui-state-focus", 
			".ui-state-default a", 
			".ui-state-active a", 
			".ui-state-hover a", 
			".ui-state-focus a"
		];
		
		$("#dln-themer-getcss").on("click.themer", function(e) {
			$("#dln-themer-css-dialog textarea").val(generateCSS("../"));
			$("#dln-themer-css-dialog").dialog("open");
			e.preventDefault();
		});
		
		var presetDd = $('<select id="dln-theme-presets"></select>');
		$.each(presets, function( i, p ) {
			var option = $("<option></option>").text(p.name).val(i);
			presetDd.append(option);
		});
		$("#dln-theme-presets-container").append(presetDd);
		
		presetDd.on('change.themer', function(e) {
			updateBaseColor(presets[presetDd.val()].baseColor);
			updateHighlightColor(presets[presetDd.val()].highlightColor);
			updateTextColor(presets[presetDd.val()].textColor);
			
			updateTextGlowColor(presets[presetDd.val()].textGlowColor, presets[presetDd.val()].textGlowColor.a);
			
			attachStylesheet();
			
			e.preventDefault();
		});
		
		
		var patternDd = $('<select id="dln-theme-patterns"></select>');
		$.each(patterns, function( i, p ) {
			var option = $("<option></option>").text(p.name).val(i);
			patternDd.append(option);
		});
		$("#dln-theme-pattern-container").append(patternDd);
		
		patternDd.on('change', function(e) {
			updateBackground(patterns[patternDd.val()].img, true);
			e.preventDefault();
		});
		
		$("div#dln-themer #dln-themer-toggle").on("click", function(e) {
			var toggle = $(this);
			if($(this).hasClass("opened")) {
				toggle.parent().stop().animate({right: "0"}, "slow", function() {
					toggle.removeClass('opened');
				});
			} else {
				toggle.parent().stop().animate({right: "256"}, "slow", function() {
					toggle.addClass('opened');
				});
			}
		});
		
		$("div#dln-themer #dln-textglow-op").slider({
			range: "min", 
			min:0, 
			max: 100, 
			value: 50, 
			slide: function(event, ui) {
				alpha = ui.value * 1.0 / 100.0;
				updateTextGlowColor(null, alpha);
			}
		});
		
		$("div#dln-themer #dln-themer-css-dialog").dialog({
			autoOpen: false, 
			title: "Theme CSS", 
			width: 500, 
			modal: true, 
			resize: false, 
			buttons: {
				"Close": function() { $(this).dialog("close"); }
			}
		});
		
		$("#dln-base-cp").ColorPicker({
			color: baseColor, 
			onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
			},
			onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
			},
			onChange: function (hsb, hex, rgb) {			
				updateBaseColor(hex, true);
			}
		});
		
		$("#dln-highlight-cp").ColorPicker({
			color: highlightColor, 
			onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
			},
			onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
			},
			onChange: function (hsb, hex, rgb) {			
				updateHighlightColor(hex, true);
			}
		});
		
		$("#dln-text-cp").ColorPicker({
			color: textColor, 
			onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
			},
			onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
			},
			onChange: function (hsb, hex, rgb) {			
				updateTextColor(hex, true);
			}
		});
		
		$("#dln-textglow-cp").ColorPicker({
			color: textGlowColor, 
			onShow: function (colpkr) {
					$(colpkr).fadeIn(500);
					return false;
			},
			onHide: function (colpkr) {
					$(colpkr).fadeOut(500);
					return false;
			},
			onChange: function (hsb, hex, rgb) {
				updateTextGlowColor(rgb, textGlowColor["a"], true);
			}
		});
		
		function updateBackground(bg, attach)
		{
			backgroundPattern = bg;
			
			if(attach == true)
				attachStylesheet();
		}
		
		function updateBaseColor(hex, attach)
		{
			baseColor = "#" + hex;
			$("#dln-base-cp").css('backgroundColor', baseColor);
			
			if(attach === true)
				attachStylesheet();
		}
		
		function updateHighlightColor(hex, attach)
		{
			highlightColor = "#" + hex;
			$("#dln-highlight-cp").css('backgroundColor', highlightColor);
			
			if(attach === true)
				attachStylesheet();
		}
		
		function updateTextColor(hex, attach)
		{
			textColor = "#" + hex;
			$("#dln-text-cp").css('backgroundColor', textColor);
			
			if(attach === true)
				attachStylesheet();
		}
		
		function updateTextGlowColor(rgb, alpha, attach)
		{
			if(rgb != null) {
				textGlowColor.r = rgb["r"];
				textGlowColor.g = rgb["g"];
				textGlowColor.b = rgb["b"];
				textGlowColor.a = alpha;
			} else {
				textGlowColor.a = alpha;
			}
			
			$("div#dln-themer #dln-textglow-op").slider("value", textGlowColor.a * 100);
			$("#dln-textglow-cp").css('backgroundColor', '#' + rgbToHex(textGlowColor.r, textGlowColor.g, textGlowColor.b));
			
			if(attach === true)
				attachStylesheet();
		}
		
		function attachStylesheet(basePath)
		{
			if($("#dln-stylesheet-holder").size() == 0) {
				$('body').append('<div id="dln-stylesheet-holder"></div>');
			}
			
			$("#dln-stylesheet-holder").html($('<style type="text/css">' + generateCSS(basePath) + '</style>'));
		}
		
		function generateCSS(basePath)
		{
			if(!basePath)
				basePath = "";
				
			var css = 
				backgroundTargets.join(", \n") + "\n" + 
				"{\n"+
				"	background-image:url('" + basePath + backgroundPattern + "');\n"+
				"}\n\n"+			
				baseColorTargets.join(", \n") + "\n" + 
				"{\n"+
				"	background-color:" + baseColor + ";\n"+
				"}\n\n"+
				borderColorTargets.join(", \n") + "\n" + 
				"{\n"+
				"	border-color:" + highlightColor + ";\n"+
				"}\n\n"+
				textTargets.join(", \n") + "\n" + 
				"{\n"+
				"	color:" + textColor + ";\n"+
				"	text-shadow:0 0 6px rgba(" + getTextGlowArray().join(", ") + ");\n"+
				"}\n\n"+
				highlightColorTargets.join(", \n") + "\n" + 
				"{\n"+
				"	background-color:" + highlightColor + ";\n"+
				"}\n";
				
			return css;
		}
		
		function getTextGlowArray()
		{
			var array = new Array();
			for(var i in textGlowColor)
				array.push(textGlowColor[i]);
				
			return array;
		}
		
		function rgbToHex(r, g, b)
		{
			var rgb = b | (g << 8) | (r << 16);
			return rgb.toString(16);
		}
	});
}) (jQuery);