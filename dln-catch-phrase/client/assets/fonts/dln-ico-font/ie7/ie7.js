/* To avoid CSS expressions while still supporting IE 7 and IE 6, use this script */
/* The script tag referring to this file must be placed before the ending body tag. */

/* Use conditional comments in order to target IE 7 and older:
	<!--[if lt IE 8]><!-->
	<script src="ie7/ie7.js"></script>
	<!--<![endif]-->
*/

(function() {
	function addIcon(el, entity) {
		var html = el.innerHTML;
		el.innerHTML = '<span style="font-family: \'dln-ico-font\'">' + entity + '</span>' + html;
	}
	var icons = {
		'dln-ico-heart': '&#xe600;',
		'dln-ico-cloud': '&#xe601;',
		'dln-ico-star': '&#xe602;',
		'dln-ico-tv': '&#xe603;',
		'dln-ico-sound': '&#xe604;',
		'dln-ico-video': '&#xe605;',
		'dln-ico-trash': '&#xe606;',
		'dln-ico-user': '&#xe607;',
		'dln-ico-key': '&#xe608;',
		'dln-ico-search': '&#xe609;',
		'dln-ico-settings': '&#xe60a;',
		'dln-ico-camera': '&#xe60b;',
		'dln-ico-tag': '&#xe60c;',
		'dln-ico-lock': '&#xe60d;',
		'dln-ico-bulb': '&#xe60e;',
		'dln-ico-pen': '&#xe60f;',
		'dln-ico-diamond': '&#xe610;',
		'dln-ico-display': '&#xe611;',
		'dln-ico-location': '&#xe612;',
		'dln-ico-eye': '&#xe613;',
		'dln-ico-bubble': '&#xe614;',
		'dln-ico-stack': '&#xe615;',
		'dln-ico-cup': '&#xe616;',
		'dln-ico-phone': '&#xe617;',
		'dln-ico-news': '&#xe618;',
		'dln-ico-mail': '&#xe619;',
		'dln-ico-like': '&#xe61a;',
		'dln-ico-photo': '&#xe61b;',
		'dln-ico-note': '&#xe61c;',
		'dln-ico-clock': '&#xe61d;',
		'dln-ico-paperplane': '&#xe61e;',
		'dln-ico-params': '&#xe61f;',
		'dln-ico-banknote': '&#xe620;',
		'dln-ico-data': '&#xe621;',
		'dln-ico-music': '&#xe622;',
		'dln-ico-megaphone': '&#xe623;',
		'dln-ico-study': '&#xe624;',
		'dln-ico-lab': '&#xe625;',
		'dln-ico-food': '&#xe626;',
		'dln-ico-t-shirt': '&#xe627;',
		'dln-ico-fire': '&#xe628;',
		'dln-ico-clip': '&#xe629;',
		'dln-ico-shop': '&#xe62a;',
		'dln-ico-calendar': '&#xe62b;',
		'dln-ico-wallet': '&#xe62c;',
		'dln-ico-vynil': '&#xe62d;',
		'dln-ico-truck': '&#xe62e;',
		'dln-ico-world': '&#xe62f;',
		'0': 0
		},
		els = document.getElementsByTagName('*'),
		i, c, el;
	for (i = 0; ; i += 1) {
		el = els[i];
		if(!el) {
			break;
		}
		c = el.className;
		c = c.match(/dln-ico-[^\s'"]+/);
		if (c && icons[c[0]]) {
			addIcon(el, icons[c[0]]);
		}
	}
}());
